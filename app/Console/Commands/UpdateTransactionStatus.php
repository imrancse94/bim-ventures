<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Utils\TransactionStatus;
use Illuminate\Console\Command;

class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transactionStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cronjob will run every night at 1:00am';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info($this->signature.' cronjob started');

        $current_datetime = getSystemCurrentDateTime('Y-m-d');
        
        (new Transaction())->updateByCondition(function($q) use ($current_datetime){
                                return $q->where('transaction_status', '=', TransactionStatus::OUTSTANDING_STATUS)
                                        ->where('created_at', '>',$current_datetime);
                        },[
                            'transaction_status' => TransactionStatus::OVERDUE_STATUS
                        ]);

        info($this->signature.' cronjob ended');
    }
}
