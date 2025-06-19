<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->query('key') === config('services.api.token');
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Неверный токен',
        ], 403));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }

    public function wantsJson()
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'dateFrom.required' => 'Параметр dateFrom обязателен.',
            'dateFrom.date_format' => 'Параметр dateFrom должен быть в формате Y-m-d (например, 2025-06-05).',

            'dateTo.required' => 'Параметр dateTo обязателен.',
            'dateTo.date_format' => 'Параметр dateTo должен быть в формате Y-m-d.',

            'page.integer' => 'Параметр page должен быть числом.',
            'page.min' => 'Минимальное значение параметра page — 1.',

            'limit.integer' => 'Параметр limit должен быть числом.',
            'limit.min' => 'Минимальное значение параметра limit — 1.',
            'limit.max' => 'Максимальное значение параметра limit — 500.',

            'key.required' => 'Передайте параметр key для авторизации.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
