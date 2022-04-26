<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:8|max:20',
            'new_password' => 'required|string|min:8|max:20|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => __('required', ['attr' => __('password')]),
            'password.string' => __('string', ['attr' => __('password')]),
            'password.min' => __('min', ['attr' => __('password'), 'value' => '8']),
            'password.max' => __('max', ['attr' => __('password'), 'value' => '20']),
            'new_password.required' => __('required', ['attr' => __('new password')]),
            'new_password.string' => __('string', ['attr' => __('new password')]),
            'new_password.min' => __('min', ['attr' => __('new password'), 'value' => '8']),
            'new_password.max' => __('max', ['attr' => __('new password'), 'value' => '20']),
            'new_password.confirmed' => __('confirmed', ['attr' => __('new password')]),
        ];
    }
}
