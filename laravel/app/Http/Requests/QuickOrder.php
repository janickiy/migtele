<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickOrder extends FormRequest
{

    protected $errorBag = 'quick_order';

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
            'email' => 'required|email|string|max:255',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#quick-order';
    }
}
