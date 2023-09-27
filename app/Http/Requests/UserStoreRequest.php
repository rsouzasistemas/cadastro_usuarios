<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation() : void
    {
        if ($this->phones) {
            foreach ($this->phones as $keyPhone => $phone) {
                $newPhones[$keyPhone] = preg_replace('/[^0-9]+/', '', $phone);
            }
        }

        $this->merge([
            'phones' => $newPhones
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:150'],
            'email' => ['required', 'min:3', 'max:150', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:32'],
            'phones' => ['required','array'],
            'phones.*.phone' => ['required', 'min:10', 'max:11'],
        ];
    }
}
