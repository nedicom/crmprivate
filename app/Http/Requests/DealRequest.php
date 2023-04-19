<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string  $name
 * @property string  $description
 * @property boolean $status
 * @property int $clientId // ID Клиента
 * @property int $lawyerId // ID Юриста
 */
class DealRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'description' => 'string|max:500|nullable',
            'clientId' => 'required|integer',
            'lawyerId' => 'required|integer',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно',
            'name.max' => 'Название должно быть не больше 100 символов',
            'description.max' => 'Описание должно быть не больше 500 символов',
        ];
    }
}
