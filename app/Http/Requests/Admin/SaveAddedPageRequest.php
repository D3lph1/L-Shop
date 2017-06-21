<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveAddedPageRequest extends FormRequest
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
            'page_title' => 'required|min:2|max:191',
            'page_content' => 'required',
            'page_url' => 'required|min:2|max:191|unique:pages,url|regex:/^[a-z_\-`0-9]+$/ui'
        ];
   }
}
