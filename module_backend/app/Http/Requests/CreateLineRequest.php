<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLineRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => "required|regex:/^[A-Z]{1,4}$/|unique:lines,code",
            'name' => "required",
            "station_a_code" => "required|exists:stations,code",
            "station_b_code" => "required|exists:stations,code|different:station_a_code",
            "seat_capacity" => "required|integer|between:1,500",
            "crossing_minutes" => "required|integer|between:1,120",
            "fare_cny" => "required|decimal:2|between:0,999.99",
            "status" => "nullable|in:active,inactive",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "message" => "Validation failed",
            "errors" => $validator->errors()
        ],422));
    }
}
