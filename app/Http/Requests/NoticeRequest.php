<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'details' => ['required', 'file', 'mimes:pdf', 'max:2048']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title.',
            'details.required' => 'Please upload a PDF file.',
            'details.mimes' => 'The file must be a PDF.',
            'details.max' => 'The PDF may not be greater than 2MB.',
        ];
    }

    /**
     * Generate an excerpt from a string
     *
     * @param string $str
     * @param int $startPos
     * @param int $maxLength
     * @return string
     */
    public static function getExcerpt($str, $startPos = 0, $maxLength = 250): string
    {
        $str = strip_tags($str); // prevent HTML breaking excerpts

        if (strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength - 6);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= ' ...';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }
}
