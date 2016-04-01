<?php namespace App\Http\Requests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ArticlesPostCreateRequest
 *
 * @package App\Http\Requests
 */
class ArticlesPostCreateRequest extends Request
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
            'res_id' => 'exists:articles',
            'name' => 'required|min:1',
            'title' => 'required|min:3|max:50',
            'body' => 'required|min:10|max:1024',
            'file1' => 'image|max:4096', // php.iniのupload_max_filesize = 5Mへ
            'file2' => 'image|max:4096',
            'password' => 'alpha_num|max:16',
            'mail' => 'email|max:50',
        ];

        // sex
        $sex = implode(',', array_keys(Config::get('const.sex')));
        $rules['sex'] = 'required|integer|in:'.substr($sex, 2);

        // age
        $age = implode(',', array_keys(Config::get('const.age')));
        $rules['age'] = 'required|integer|in:'.substr($age, 2);

        // prefectures
        $prefectures = implode(',', array_keys(Config::get('const.prefectures')));
        $rules['prefectures'] = 'required|integer|in:'.substr($prefectures, 2);

        // interests
        $interests = DB::table('interests')->get();
        foreach ($interests as $row) {
            $rules[$row->name_tag] = 'exists:interests,id';
        }

        return $rules;
    }
}
