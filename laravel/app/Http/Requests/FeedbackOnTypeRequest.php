<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackOnTypeRequest extends FormRequest
{
    protected $errorBag = 'feedback';

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
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string|max:255',
            'name' => 'required_if:type,pay-products|required_if:type,cooperation|required_if:type,to-ceo|string|max:255',
            'phone' => 'required_if:type,purchase-returns|required_if:type,cooperation|nullable|string|max:255',
            'mail' => 'required|email|string|max:255',
            'message' => 'required_if:type,pay-products|required_if:type,to-ceo|nullable|string|max:1500',
            'number' => 'required_if:type,purchase-returns|nullable|string|max:255',
            'products.*' => 'required_if:type,purchase-returns|nullable|string|max:255',
            'type_problem' => 'nullable|string|max:255',
            'photo' => 'required_if:type,purchase-returns|nullable|image',
            'description_problem' => 'required_if:type,purchase-returns|nullable|string|max:1500',
            'feed_earlier' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1500',
            'feed_comm_type' => 'required_if:type,cooperation|nullable|string|max:1500',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
