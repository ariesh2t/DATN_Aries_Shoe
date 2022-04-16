<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'fname' => ['required', 'string', 'max:50'],
            'lname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:320', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ];
    }
    
    public function messages()
    {
        return [
            'fname.required' => __('required', ['attr' => __('fname')]),
            'fname.string' => __('string', ['attr' => __('fname')]),
            'fname.max' => __('max', ['attr' => __('fname'), 'value' => '50']),
            'lname.required' => __('required', ['attr' => __('lname')]),
            'lname.string' => __('string', ['attr' => __('lname')]),
            'lname.max' => __('max', ['attr' => __('lname'), 'value' => '50']),
            'email.required' => __('required', ['attr' => __('email')]),
            'email.email' => __('email_val'),
            'email.max' => __('max', ['attr' => __('email'), 'value' => '320']),
            'email.unique' => __('unique', ['attr' => __('email')]),
            'password.required' => __('required', ['attr' => __('password')]),
            'password.string' => __('string', ['attr' => __('password')]),
            'password.min' => __('min', ['attr' => __('password'), 'value' => '8']),
            'password.max' => __('max', ['attr' => __('password'), 'value' => '20']),
            'password.confirmed' => __('confirmed', ['attr' => __('password')]),
        ];
    }
}
