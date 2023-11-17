<?php

namespace App\Http\Requests;

use App\Traits\ApiResponseTrait;
use App\Utils\ApplicationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class BaseRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }


    protected function failedValidation(Validator $validator): ValidationException
    {
        $errors = (new ValidationException($validator))->errors();
        $errorData = [];
        if(!empty($errors)){
            foreach($errors as $key => $err){
                $message = current($err);
                
                $errorData[$key] = $message;
            }
        }
        
        throw new HttpResponseException($this->sendResponse($errorData,"Validation Error",ApplicationStatus::FAILED));
    }


}
