<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordPaymentRequest;
use Illuminate\Http\Request;
use App\Services\SystemUsers\ManageUsers;

class PaymentController extends Controller
{
    public function recordPayment(RecordPaymentRequest $request)
    {
        $inputData = $request->all();
        
        $result = (new ManageUsers(auth()->user()))->recordPayment($inputData);

        return $this->sendResponse(
            $result->data,
            $result->message,
            $result->response_code
        );
    }
}
