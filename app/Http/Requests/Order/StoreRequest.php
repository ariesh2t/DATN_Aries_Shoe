<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'fullname' => 'required|string|max:100',
            'phone' => ['required', 'regex:/(0[3|5|7|8|9])+([0-9]{8})\b/'],
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => __('required', ['attr' => __('fullname')]),
            'fullname.string' => __('string', ['attr' => __('fullname')]),
            'fullname.max' => __('max', ['attr' => __('fullname'), 'value' => 100]),
            'phone.required' => __('required', ['attr' => __('phone')]),
            'phone.regex' => __('regex phone'),
            'address.required' => __('required', ['attr' => __('address')]),
            'address.string' => __('string', ['attr' => __('address')]),
        ];
    }
}
