<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
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
            'title' => 'sometimes|required|max:255',
            'author' => 'sometimes|required|max:255',
            'published_at' => 'sometimes|required|date',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
    public function attributes(): array
    {
        return [
            'title' => 'اسم الكتاب',
            'author' => 'اسم المؤلف',
            'published_at' => 'تاريخ النشر',
            'is_active' => 'حالة الكتاب',
            'categoty_id' => 'معرف الفئة'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute مطلوب',
            'string' => ':attribute محارف فقط',
            'date' => ':attribute نمط تاريخ',
            'boolean' => ':attribute نمط بولياني',
            'exists:categories,id' => ':attribute غير موجود'
        ];
    }
}
