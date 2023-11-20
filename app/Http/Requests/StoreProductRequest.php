<?php

namespace App\Http\Requests;


class StoreProductRequest extends MainRequest
{
    public function rules(): array
    {
        return [
            'supplier_id'=>'nullable  | integer',
            'category_id'=>'required  | integer',
            'title'=>'required  | string',
            'description'=>'nullable  | string',
            'quantity'=>'required  | numeric',
            'frame_size'=>'required  | string',
            'price'=>'required  | numeric',
            'discount'=>'nullable  | numeric',
            'user_id'=>'nullable  | integer'
        ];
    }
    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
    }
}
