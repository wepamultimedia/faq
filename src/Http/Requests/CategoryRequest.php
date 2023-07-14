<?php

namespace Wepa\Faq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'translations.'.config('app.locale').'.name' => 'string|required',
            'translations.*.name' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'translations.'.config('app.locale').'.name.required' => __('faq::categories.name_required_default_lang', ['locale' => config('app.locale')]),
        ];
    }
}
