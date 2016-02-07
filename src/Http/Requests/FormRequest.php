<?php

namespace TypiCMS\Modules\News\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'date'    => 'required|date',
            'image'   => 'image|max:2000',
            '*.title' => 'max:255',
            '*.slug'  => 'alpha_dash|max:255',
        ];
    }
}
