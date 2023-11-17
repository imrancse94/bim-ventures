<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use App\Utils\TransactionStatus;

class TestController extends Controller
{
    public function testing(){

    
    //  $transactions = Transaction::leftjoin('payments','payments.transaction_id','transactions.id')
    //                 ->select(['transactions.*','payments.amount as paid_amount','payments.id as payment_id','payments.paid_on'])  
    //                 ->orderBy('created_at', 'ASC')
    //                 ->get();

    $start = "2023-01-01";
    $end = "2024-01-01";
    
    $result = (new TransactionService)->getReportData($start,$end);
      
     return response()->json($result,200);
      
        
    }
}
