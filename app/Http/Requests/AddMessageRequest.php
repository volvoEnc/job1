<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMessageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required', 'max:2000', 'string'],
            'attachments[]' => ['file', 'max:4096']
        ];
    }
}
