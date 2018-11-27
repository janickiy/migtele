<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Dealer extends FormRequest
{

    protected $errorBag = 'dealer';

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
            'product_id' => 'required',
            'products_count' => 'required|integer',
            'notes' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        return $url->previous() . '#dealer-form';
    }
}
