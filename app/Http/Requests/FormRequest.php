<?php
/**
 * Created by PhpStorm.
 * User: Lester Hurtado
 * Date: 10/20/17
 * Time: 3:02 AM
 */

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        if  ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'data' => $errors
                ], 422)
            );
        }
        parent::failedValidation($validator);
    }
}