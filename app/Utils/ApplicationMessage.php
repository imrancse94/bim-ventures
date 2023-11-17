<?php

namespace App\Utils;

class ApplicationMessage 
{
    const OPERATION_NOT_PERMITTED = 'This operation not permitted for you.';

    const TRANSACTION_FETCHED_SUCCESS = 'Transaction fetched successfully.';
    
    const TRANSACTION_NOT_FOUND = 'No transaction found.';

    const TRANSACTION_CREATED_SUCCESS = 'Transaction created successfully.';

    const TRANSACTION_CREATED_FAILED = 'Transaction created failed.';

    const PAYMENT_ADDED_SUCCESS = 'Payment has recored successfully.';

    const PAYMENT_ADDED_FAILED = 'Payment has failed to recored.';

    const GREATER_PAYMENT = 'Payment is greater than due.';

    const ALREADY_PAYMENT = 'This transaction already paid.';

    const REPORT_GENERTAED_SUCCESS = 'The report has generated successfully.';
    
    const REPORT_GENERTAED_FAILED = 'The report has failed to generate.';
}