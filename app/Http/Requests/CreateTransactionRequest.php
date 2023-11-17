<?php

namespace App\Http\Requests;


class CreateTransactionRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'due_date' => 'required|date|after:yesterday',
            'customer_id'=> 'required|integer|exists:users,id',
            'amount'=> 'required|numeric|gt:0',
            'vat'=> 'required|integer',
            'is_vat_included'=> 'required|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'is_vat_included.in'=>'You must have to enter 0 or 1 (1 = vat included, 0 = not included)',
            'due_date.after'=> 'Due date must be today or future date'
        ];
    }
}
