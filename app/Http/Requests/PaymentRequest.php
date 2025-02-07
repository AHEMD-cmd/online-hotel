<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

class PaymentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'billing_name' => 'required|string',
            'billing_email' => 'required|email|string',
            'billing_phone' => ['required', function ($attribute, $value, $fail) {
                $phoneUtil = PhoneNumberUtil::getInstance();
                try {
                    $number = $phoneUtil->parse($value, null);

                    if (!$phoneUtil->isValidNumber($number)) {
                        $fail('The phone number is not valid.');
                    }
                } catch (NumberParseException $e) {
                    $fail('Invalid phone number format.');
                }
            }],
            'billing_country' => 'required|string',
            'billing_address' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_zip' => 'required|numeric'
        ];
    }
}
