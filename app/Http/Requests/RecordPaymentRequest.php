<?php

namespace App\Http\Requests;


class RecordPaymentRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id'=>'required',
            'amount'=> 'required|numeric|gt:0',
            'paid_on'=>'required|date',
            'details'=>'nullable'
        ];
    }
}
