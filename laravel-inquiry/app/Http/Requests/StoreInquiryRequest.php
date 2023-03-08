<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\InquiryType;
use Illuminate\Validation\Rules\Enum;

class StoreInquiryRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255',
            'type'=>[new Enum(InquiryType::class)],
            'content'=>'required|max:1000',
        ];
    }

    /**
     * @return array<string>
     */
    public function attributes(): array
    {
        return[
            'name'=>'名前',
            'email'=>'メールアドレス',
            'type'=>'種別',
            'content'=>'問合せ内容',
        ];
    }

    /**
     * @return array<string>
     */
    public function messages(): array
    {
        return [
            'name.required'=>':attributeを入力して下さい。',
            'name.max'=>':attributeは２５５文字以下で入力して下さい。',
            'email.required'=>':attributeを入力して下さい。',
            'email.max'=>':attributeは２５５文字以下で入力して下さい。',
            'type'=>':attributeに不正な値が入力されています。',
            'content.required'=>':attributeを入力して下さい。',
        ];
    }
}
