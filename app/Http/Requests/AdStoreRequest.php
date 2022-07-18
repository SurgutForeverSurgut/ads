<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Validator;

class AdStoreRequest extends FormRequest
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
            'name' => 'required|unique:ads|max:200',
            'description' => 'required|max:1000',
            'images' => 'array|size:3'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $f = $validator->passes();
        $e = $validator->errors();

        $r = 1;
    }
    
}
