<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Feedback extends FormRequest
{
    protected $errorBag = 'feedback_form';

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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'mail' => 'required|email|string|max:255',
            'notes' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#feedback-form';
    }
}
