<?php

namespace App\Utils;

class TransactionStatus {

    const OUTSTANDING_STATUS = 1;
    const OVERDUE_STATUS = 3;
    const PAID_STATUS = 2;

    const STATUS_LIST = [
        self::OUTSTANDING_STATUS => 'outstanding',
        self::OVERDUE_STATUS => 'overdue',
        self::PAID_STATUS => 'paid'
    ];
}