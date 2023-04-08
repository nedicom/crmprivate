<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PaymentsRequest extends FormRequest
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
          'summ' => 'numeric',
          'client' => 'required',
          'calculation' => 'required',
          'service' => 'required'
        ];
    }

    public function messages(){
      return [
        'summ' => 'В поле сумма допускаются только числа (не используйте запятую)',
        'client' => 'укажите клиента',
        'calculation' => 'Укажите способ платежа',
        'service' => 'укажите название услуги'
      ];
    }
}
