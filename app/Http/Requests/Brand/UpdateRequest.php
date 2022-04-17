<?php

namespace App\Http\Requests\Brand;

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
            'name' => 'required|string|unique:brands,name,' . request()->id,
            'image.*' => 'mimes:png,jpg,jpeg,gif',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('required', ['attr' => __('brand name')]),
            'name.string' => __('string', ['attr' => __('brand name')]),
            'name.unique' => __('unique', ['attr' => __('brand name')]),
            'image.*.mimes' => __('mimes', ['attr' => __('image')]),
        ];
    }
}
