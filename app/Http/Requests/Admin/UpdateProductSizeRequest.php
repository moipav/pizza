<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductSizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * TODO добавить авторизацию
         */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productSizeId = $this->route('product_size');
        return [
            'product_id' => 'required|exists:products,id',
            'size_name' => 'required|string|max:50',
            'size_value' => [
                'required',
                'numeric',
                Rule::unique('product_sizes')
                    ->where('product_id', $this->input('product_id'))
                    ->where('size_name', $this->input('size_name'))
                    ->where('size_value', $this->input('size_value'))
                    ->ignore($productSizeId)
            ],
            'unit' => 'required|string|max:10',
            'price_adjustment' => 'required|numeric|min:0',
        ];
    }
}
