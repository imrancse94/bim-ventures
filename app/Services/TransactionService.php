<?php


namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Utils\ApplicationMessage;
use App\Utils\TransactionStatus;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    public function processTransaction($inputData)
    {
        $due_date = $inputData['due_date'];

        $transactionData['user_id'] = $inputData['customer_id'];
        $transactionData['due_date'] = $due_date;
        $transactionData['transaction_id'] = generateUniqueId();
        $transactionData['amount'] = $inputData['amount'];
        $transactionData['vat'] = $inputData['vat'];
        $transactionData['is_vat_included'] = $inputData['is_vat_included'];
        $transactionData['transaction_status'] = TransactionStatus::OUTSTANDING_STATUS;

        if (isPastDate($due_date)) {
            $transactionData['transaction_status'] = TransactionStatus::OVERDUE_STATUS;
        }

        return (new Transaction())->add($transactionData);
    }



    public function processRecordPayment($inputData)
    {
        $result['status'] = false;

        $result['message'] = ApplicationMessage::PAYMENT_ADDED_FAILED;

        $transaction_unique_id = $inputData['transaction_id'];

        $transaction = (new Transaction())->findByCondition(function ($q) use ($transaction_unique_id) {
            return $q->where('transaction_id', $transaction_unique_id);
        });

        if (empty($transaction)) {

            $result['message'] = ApplicationMessage::TRANSACTION_NOT_FOUND;

            return $result;
        }

        if ($transaction->transaction_status == TransactionStatus::PAID_STATUS) {
            $result['message'] = ApplicationMessage::ALREADY_PAYMENT;

            return $result;
        }

        $payment = new Payment();

        $total_previous_amount = $payment->getTotalAmountByTransactionId($transaction->id);

        $total_amount = $total_previous_amount + $inputData['amount'];

        if ($total_amount > $transaction->amount) {
            $result['message'] = ApplicationMessage::GREATER_PAYMENT;

            return $result;
        }

        try {

            DB::beginTransaction();

            $paymentInsertData['amount'] = $inputData['amount'];

            $paymentInsertData['transaction_id'] = $transaction->id;

            $paymentInsertData['paid_on'] = $inputData['paid_on'];

            $paymentInsertData['comments'] = $inputData['details'] ?? null;

            $payment->add($paymentInsertData);

            $is_updateable = false;

            if ($total_amount == $transaction->amount) {
                $transaction->transaction_status = TransactionStatus::PAID_STATUS;

                $is_updateable = true;
            } else if (isPastDate($transaction->due_date)) {
                $transaction->transaction_status = TransactionStatus::OVERDUE_STATUS;
            }


            if ($is_updateable) {
                $transaction->save();
            }

            DB::commit();

            $result['status'] = true;

            $result['message'] = ApplicationMessage::PAYMENT_ADDED_SUCCESS;
        } catch (Exception $ex) {

            DB::rollBack();
        }

        return $result;
    }


    public function getReportData($start_date, $end_date)
    {

        $transactions = (new Transaction)->getTransactionWithPayments($start_date, $end_date);

        $result = [];

        $paidData = [];
        $overdueData = [];
        $outstandingData = [];

        if (!empty($transactions)) {

            foreach ($transactions as $transaction) {

                $split_date = splitDate($transaction->created_at);

                $transaction_status = $transaction->transaction_status;

                $paid_amount = 0;

                $outstanding_amount = 0;

                $overdue_amount = 0;

                // if transaction status is paid then it taken as paid item    
                if ($transaction_status == TransactionStatus::PAID_STATUS) {
                    
                    $paid_amount = $transaction->amount;

                } else {

                    $payments = $transaction->payments;

                    if (!empty($payments)) {
                        foreach ($payments as $payment) {

                            $paid_amount += $payment->amount;
                        }
                    }

                    // Checking if the deate is past or not
                    $is_past_date = isPastDate($transaction->created_at);

                    if ($is_past_date) 
                    {
                        $overdue_amount = $transaction->amount - $paid_amount;
                    
                    } else 
                    {
                        $outstanding_amount = $transaction->amount - $paid_amount;
                    }
                }

                // For uniquely identify month and year 
                $key = $split_date['month'] . "_" . $split_date['year'];

                $paidData[$key] = ($paidData[$key] ?? 0) + $paid_amount;

                $outstandingData[$key] = ($outstandingData[$key] ?? 0) + $outstanding_amount;

                $overdueData[$key] = ($overdueData[$key] ?? 0) + $overdue_amount;

                $result[$key] = [
                    'month' => $split_date['month'],
                    'year' => $split_date['year'],
                    'paid' => $paidData[$key],
                    'outstanding' => $outstandingData[$key],
                    'overdue' => $overdueData[$key]
                ];
            }
        }

        return array_values($result);
    }


    public function getTransactionsForUser($filter)
    {
        $result = [];

        $transactions = (new Transaction())->getByCondition($filter);

        if(!empty($transactions)){
            foreach($transactions as $transaction)
            {
                $vat_include = $transaction->is_vat_included == 1 ? 'included':'not included';
                
                $result[] = [
                    'transaction_id' => $transaction->transaction_id,
                    'amount' => $transaction->amount,
                    'due_date' => $transaction->due_date,
                    'status' => getTransactionStatus($transaction->transaction_status,$transaction->due_date),
                    'vat' => $transaction->vat."(".$vat_include.")",
                ];
            }
        }

        return $result;
    }
}
