<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'kana' => ['required', 'regex:/^[ァ-ヾ　 〜ー]+$/u', 'max:50'],
            'tel' => ['required', 'max:20', 'unique:customers,tel'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'postcode' => ['required', 'max:7'],
            'address' => ['required', 'max:100'],
            'birthday' => ['date'],
            'gender' => ['required'],
            'memo' => ['max:1000'],
        ];
    }

    public function prepareForValidation()
    {
        // 「半角カタカナ」->「全角カタカナ」(K)
        // 「全角ひらがな」->「全角カタカナ」(C)
        // 「全角」スペース->「半角」(s)
        // 「半角」英数字->「全角」(A)

        $this->merge(['kana' => mb_convert_kana($this->kana, 'KCsA')]);
        $this->merge(['name' => mb_convert_kana($this->name, 'KCsA')]);
    }
}
