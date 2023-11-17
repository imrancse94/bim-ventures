<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\ReportRequest;
use App\Services\SystemUsers\ManageUsers;

class TransactionController extends Controller
{
    public function getTransactions()
    {
        $result = (new ManageUsers(auth()->user()))->getAllTransactions();

        return $this->sendResponse(
            $result->data,
            $result->message,
            $result->response_code
        );
    }

    public function create(CreateTransactionRequest $request)
    {
        $inputData = $request->all();
        
        $result = (new ManageUsers(auth()->user()))->createTransaction($inputData);

        return $this->sendResponse(
            $result->data,
            $result->message,
            $result->response_code
        );
    }

    public function generateReport(ReportRequest $request)
    {
        $inputData = $request->all();
        
        $start_date = $inputData['from_date'];
        
        $end_date = $inputData['end_date'];

        $result = (new ManageUsers(auth()->user()))->generateReport($start_date,$end_date);

        return $this->sendResponse(
            $result->data,
            $result->message,
            $result->response_code
        );
    }
}
