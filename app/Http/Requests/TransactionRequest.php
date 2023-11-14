<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'cargo_fee' => ['required', 'integer'],
            'total_balance' => ['required', 'integer'],
            'grand_total' => ['required', 'integer'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal harus diisi!',
            'cargo_fee.required' => 'Cargo Fee harus diisi!',
            'total_balance.required' => 'Total Balance harus diisi!',
            'grand_total.required' => 'Grand Total harus diisi!',

            'date.date' => 'Tanggal tidak diisi dengan benar!',
            'cargo_fee.numeric' => 'Cargo Fee harus berupa angka!',
            'total_balance.numeric' => 'Total Balance harus berupa angka!',
            'grand_total.numeric' => 'Grand Total harus berupa angka!',
        ];
    }
}
