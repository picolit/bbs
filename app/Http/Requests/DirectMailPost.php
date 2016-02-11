<?php namespace App\Http\Requests;

/**
 * Class InquiryPostRequest
 *
 * @package App\Http\Requests
 */
class InquiryPostRequest extends Request
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
            'name' => 'required',
            'title' => 'required|max:50',
            'body' => 'required|min:1|max:1024',
            'email' => 'required|email',
        ];
    }
}
