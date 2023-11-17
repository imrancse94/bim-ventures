<?php

namespace App\Http\Requests;


class ReportRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from_date'=>'required',
            'end_date'=>'required'
        ];
    }
}
