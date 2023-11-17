<?php


namespace App\Services\SystemUsers;

use App\Models\Transaction;
use App\Services\Service;
use App\Services\TransactionService;

class Admin extends Service implements ActionInterface,ViewInterface
{
    private $auth = null;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function createTransaction($inputData)
    {
        return (new TransactionService())->processTransaction($inputData);
    }
    
    public function recordPayment($inputData)
    {
        return (new TransactionService())->processRecordPayment($inputData);
    }

    public function generateReport($start_date, $end_date)
    {
        return (new TransactionService())->getReportData($start_date,$end_date);
    }

    public function getTransactions()
    {
        return (new TransactionService())->getTransactionsForUser([]);
    }
}