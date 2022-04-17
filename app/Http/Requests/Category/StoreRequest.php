<?php

namespace App\Http\Requests\Category;

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
            'name' => 'required|string|unique:categories',
            'image' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg,gif',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('required', ['attr' => __('category name')]),
            'name.string' => __('string', ['attr' => __('category name')]),
            'name.unique' => __('unique', ['attr' => __('category name')]),
            'image.required' => __('required', ['attr' => __('image')]),
            'image.*.mimes' => __('mimes', ['attr' => __('image')]),
        ];
    }
}
