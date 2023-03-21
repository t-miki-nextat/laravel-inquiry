<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users', 'string', 'max:255'],
            'password'=>['required', 'string'],
        ];
    }

    /**
     * @return array<string>
     */
    public function attributes(): array
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
        ];
    }
}
