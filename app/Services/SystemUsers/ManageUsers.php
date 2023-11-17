<?php


namespace App\Services\SystemUsers;

use App\Services\Service;
use App\Utils\ApplicationMessage;
use App\Utils\ApplicationStatus;

class ManageUsers extends Service
{
    const ADMIN_USER_TYPE = 1;

    const CUSTOMER_USER_TYPE = 2;
    
    private $userObj = null;

    
    public function __construct($auth_user)
    {
        $user_type = $auth_user->user_type;

        if($user_type == self::ADMIN_USER_TYPE)
        {
            $this->userObj = new Admin($auth_user);

        }else if($user_type == self::CUSTOMER_USER_TYPE)
        {
            $this->userObj = new Customer($auth_user);
        }
    }


    public function getAllTransactions()
    {
        $this->response_code = ApplicationStatus::FAILED;

        $this->message = __('No transaction found');

        $this->data = $this->userObj->getTransactions();

        if(!empty($this->data)){

            $this->response_code = ApplicationStatus::SUCCESS;
        
            $this->message = __('Transactions fetched successfully');
        }

        return $this;
    }


    public function createTransaction($inputData)
    {
        $this->response_code = ApplicationStatus::FAILED;

        $this->message = __(ApplicationMessage::TRANSACTION_CREATED_FAILED);

        if(!$this->userObj instanceof ActionInterface){
            
            $this->message = __(ApplicationMessage::OPERATION_NOT_PERMITTED);

            return $this;

        }

        $this->data = $this->userObj->createTransaction($inputData);

        if(!empty($this->data)){

            $this->response_code = ApplicationStatus::SUCCESS;
        
            $this->message = __(ApplicationMessage::TRANSACTION_CREATED_SUCCESS);
        }

        return $this;
    }


    public function recordPayment($inputData)
    {
        $this->response_code = ApplicationStatus::FAILED;

        $this->message = __(ApplicationMessage::PAYMENT_ADDED_FAILED);

        if(!$this->userObj instanceof ActionInterface){
            
            $this->message = __(ApplicationMessage::OPERATION_NOT_PERMITTED);

            return $this;

        }

        $this->data = $this->userObj->recordPayment($inputData);

        $this->message = __($this->data['message']);

        if($this->data['status']){

            $this->response_code = ApplicationStatus::SUCCESS;
        
        }

        $this->data = [];

        return $this;
    }

    
    public function generateReport($start_date, $end_date)
    {
        $this->response_code = ApplicationStatus::FAILED;

        $this->message = __(ApplicationMessage::REPORT_GENERTAED_FAILED);

        if(!$this->userObj instanceof ActionInterface){
            
            $this->message = __(ApplicationMessage::OPERATION_NOT_PERMITTED);

            return $this;

        }

        $this->data = $this->userObj->generateReport($start_date, $end_date);


        if(!empty($this->data)){

            $this->response_code = ApplicationStatus::SUCCESS;
        
            $this->message = __(ApplicationMessage::REPORT_GENERTAED_SUCCESS);
        }

        return $this;
    }

}