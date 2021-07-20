<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'event_id'=>'integer|required',
            'event_date'=>'datetime|required',
            'ticket_adult_price'=>'integer|required',
            'ticket_adult_quantity'=>'integer|required',
            'ticket_kid_price'=>'integer|required',
            'ticket_kid_quantity'=>'integer|required'
        ];
    }
}
