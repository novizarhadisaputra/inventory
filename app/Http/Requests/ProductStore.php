<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Urameshibr\Requests\FormRequest;
use App\Http\Transformers\ResponseTransformer;

class ProductStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'code' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'supplier_id' => ['required']
        ];
    }

    public function response(array $errors)
    {
        return (new ResponseTransformer($errors, 'Unprocessable Content', 422))->toJson();
    }
}
