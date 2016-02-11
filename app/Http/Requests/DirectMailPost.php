<?php namespace App\Http\Requests;

/**
 * Class DirectMailPost
 *
 * @package App\Http\Requests
 */
class DirectMailPost extends Request
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
            'name'  => 'required|max:10',
            'title' => 'required|max:50',
            'body'  => 'required|min:1|max:1024',
            'email' => 'required|email',
        ];
    }
}
