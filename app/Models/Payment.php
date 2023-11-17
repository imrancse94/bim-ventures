<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'paid_on',
        'amount',
        'comments'
    ];


    public function add($inputData)
    {
        return self::create($inputData);
    }

    public function getTotalAmountByTransactionId($transaction_id)
    {
        return self::where('transaction_id',$transaction_id)->sum('amount');
    }

}
