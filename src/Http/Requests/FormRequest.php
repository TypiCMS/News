<?php
namespace TypiCMS\Modules\News\Http\Requests;

use TypiCMS\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest {

    public function rules()
    {
        $rules = [
            'date' => 'required|date',
            'time' => 'date_format:G:i',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.slug'] = "required_with:$locale.title|required_if:$locale.status,1|alpha_dash";
        }
        return $rules;
    }
}
