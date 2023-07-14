<?php

namespace Wepa\Faq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerRequest extends FormRequest
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
            'category_id' => 'numeric|required',
            'translations.'.config('app.locale').'.question' => 'string|required',
            'translations.'.config('app.locale').'.answer' => 'string|required',
            'translations.*.question' => 'string|required',
            'translations.*.answer' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'category_id' => __('faq::category_id_required', ['locale' => config('app.locale')]),
            'translations.'.config('app.locale').'.question.required' => __('faq::qas.question_required_default_lang', ['locale' => config('app.locale')]),
            'translations.*.question.required' => __('faq::qas.question_required_lang', ['locale' => config('app.locale')]),
            'translations.'.config('app.locale').'.answer.required' => __('faq::qas.answer_required_default_lang', ['locale' => config('app.locale')]),
            'translations.*.answer.required' => __('faq::qas.answer_required_lang', ['locale' => config('app.locale')]),
        ];
    }
}
