<?php

namespace App\Http\Requests\Errors;

use App\Http\Requests\Request;

/**
 * Class ErrorPostRequest
 *
 * @package App\Http\Requests\Errors
 */
class ErrorPostRequest extends Request
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
        $rules = [
            'msg' => 'required',
            'url' => 'required',
            'col' => '',
        ];

        return $rules;
    }
}
