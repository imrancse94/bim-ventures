<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'due_date',
        'transaction_status',
        'user_id',
        'amount',
        'vat',
        'is_vat_included'
    ];


    public function add($inputData)
    {
        return self::create($inputData);
    }

    public function getByCondition($filter)
    {
        return self::where($filter)->get();
    }

    public function findByCondition(callable $filter)
    {
        $query = self::query();

        return $filter($query)->first();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function getTransactionWithPayments($start_date, $end_date)
    {
        return self::with('payments')->whereBetween('created_at', [$start_date, $end_date])->get();
    }


    public function updateByCondition(callable $filter,$updateData)
    {
        $query = self::query();

        return $filter($query)->update($updateData);
    }

}
