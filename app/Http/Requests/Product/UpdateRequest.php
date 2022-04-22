<?php

namespace App\Http\Requests\Product;

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
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . request()->id,
            'cost' => 'required|numeric|min:1000|max:1000000000',
            'price' => 'required|numeric|min:1000|max:1000000000',
            'promotion' => 'required|numeric|min:1000|max:1000000000',
            'images.*' => 'mimes:png,jpg,jpeg,gif',
        ];
    }

    public function messages()
    {
        return [
            'brand_id.required' => __('required', ['attr' => __('brand')]),
            'brand_id.exists' => __('exists', ['attr' => __('brand')]),
            'category_id.required' => __('required', ['attr' => __('category')]),
            'category_id.exists' => __('exists', ['attr' => __('category')]),
            'name.required' => __('required', ['attr' => __('product name')]),
            'name.string' => __('string', ['attr' => __('product name')]),
            'name.max' => __('max', ['attr' => __('product name'), 'value' => 255]),
            'name.unique' => __('unique', ['attr' => __('product name')]),
            'cost.required' => __('required', ['attr' => __('cost')]),
            'cost.numeric' => __('numeric', ['attr' => __('cost')]),
            'cost.min' => __('min numeric', ['attr' => __('cost'), 'value' => 1000]),
            'cost.max' => __('max numeric', ['attr' => __('cost'), 'value' => 1000000000]),
            'price.required' => __('required', ['attr' => __('price')]),
            'price.numeric' => __('numeric', ['attr' => __('price')]),
            'price.min' => __('min numeric', ['attr' => __('price'), 'value' => 1000]),
            'price.max' => __('max numeric', ['attr' => __('price'), 'value' => 1000000000]),
            'promotion.required' => __('required', ['attr' => __('promotion')]),
            'promotion.numeric' => __('numeric', ['attr' => __('promotion')]),
            'promotion.min' => __('min numeric', ['attr' => __('promotion'), 'value' => 1000]),
            'promotion.max' => __('max numeric', ['attr' => __('promotion'), 'value' => 1000000000]),
            'images.*.mimes' => __('mimes', ['attr' => __('image')]),
        ];
    }
}
