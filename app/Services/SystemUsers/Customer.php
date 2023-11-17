<?php


namespace App\Services\SystemUsers;

use App\Services\Service;
use App\Models\Transaction;
use App\Services\TransactionService;

class Customer extends Service implements ViewInterface
{
    private $auth = null;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function getTransactions()
    {
        $filter['user_id'] = $this->auth->id;
        return (new TransactionService())->getTransactionsForUser($filter);
    }
}