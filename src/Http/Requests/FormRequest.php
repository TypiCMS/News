<?php

namespace TypiCMS\Modules\News\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'date' => 'required|date',
            'image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255',
        ];
    }
}
