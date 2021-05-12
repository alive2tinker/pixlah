<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
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
            'duration' => "required_unless:type,video,youtube",
            'link' => "required_unless:type,image,quote,video",
            'attachment' => "required_if:type,image,video,quote|file|nullable"
        ];
    }
}
