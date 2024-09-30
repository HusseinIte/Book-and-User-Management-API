<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'اسم الكتاب',
            'author' => 'اسم المؤلف',
            'published_at' => 'تاريخ النشر',
            'category_id' => 'معرف الفئة'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute مطلوب',
            'string' => ':attribute محارف فقط',
            'date' => ':attribute نمط تاريخ',
            'exists' => ':attribute غير موجود'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
}
