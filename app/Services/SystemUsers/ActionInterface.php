<?php


namespace App\Services\SystemUsers;

interface ActionInterface 
{
    public function createTransaction($inputData);
    
    public function recordPayment($inputData);

    public function generateReport($start_date, $end_date);
}