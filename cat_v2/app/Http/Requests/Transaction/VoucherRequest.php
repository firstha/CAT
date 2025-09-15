<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'type' => 'required',
            'category_id' => 'required',
            'access_type' => 'required',
            'active_period' => 'required',
            'price_before_discount' => 'required',
            'price_after_discount' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('voucher.name'),
            'code' => __('voucher.code'),
            'category_id' => __('voucher.category_id'),
            'type' => __('voucher.type'),
            'active_period' => __('voucher.active_period'),
            'access_type' => __('voucher.access_type'),
            'price_before_discount' => __('voucher.price_before_discount'),
            'price_after_discount' => __('voucher.price_after_discount'),
            'description' => __('voucher.description'),
            'is_active' => __('voucher.is_active'),
        ];
    }
}
