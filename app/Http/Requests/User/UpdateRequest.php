<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'email' => 'required|email|max:320|unique:users,email,' . request()->id,
            'phone' => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})\b/', 'unique:users,phone,'  . request()->id],
            'image.*' => 'mimes:png,jpg,jpeg,gif',
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
            'phone.required' => __('required', ['attr' => __('phone')]),
            'phone.regex' => __('regex phone'),
            'phone.unique' => __('unique', ['attr' => __('phone')]),
            'image.*.mimes' => __('mimes', ['attr' => __('image')]),
        ];
    }
}
