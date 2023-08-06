<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
            'tel' => [
                'required', Rule::unique('customers')->ignore($this->customer), 'max:20', 'regex:/^0[0-9]{9,10}$/u'
            ],
            'email' => ['required', Rule::unique('customers')->ignore($this->customer), 'email', 'max:255'],
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
        // 「全角カタカナ」->「半角カタカナ」(k)
        // 「全角ひらがな」->「全角カタカナ」(C)
        // 「全角」スペース->「半角」(s)
        // 「全角」数字->「半角」(n)
        // 「半角」英数字->「全角」(A)
        // 「全角」英数字->「半角」(a)

        $this->merge(['kana' => mb_convert_kana($this->kana, 'Ks')]);
        $this->merge(['name' => mb_convert_kana($this->name, 'Ksa')]);
        $this->merge(['address' => mb_convert_kana($this->address, 'kans')]);
        // $this->merge(['tel' => mb_convert_kana($this->tel, 'n')]);
    }
}
