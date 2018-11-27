<?php

namespace App\Http\Requests;

use App\Model\DeliveryMethod;
use App\Model\User;
use Illuminate\Foundation\Http\FormRequest;

class Order extends FormRequest
{

    protected $errorBag = 'order';

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
        $rules = [
            'name' => 'required|string|max:190',
            'phone' => 'required|string|max:190',
            'email' => 'required|email|string|max:190',
            'company_name' => 'required_if:type,'.User::JURIDICAL_TYPE.'|string|nullable|max:190',
            'inn' => 'required_if:type,'.User::JURIDICAL_TYPE.'|string|nullable|max:190',
            'address' => 'required_if:type,'.User::JURIDICAL_TYPE.'|string|nullable|max:190',
            'company_receiver' => 'required_if:type,'.User::JURIDICAL_TYPE.'|string|nullable|max:190',
        ];

        if(env('APP_ENV') != 'local')
            $rules['g-recaptcha-response'] = 'required|captcha';

        if(request('register'))
            $rules['email'] = 'required|string|email|max:255|unique:users,email';

        return array_merge($rules, $this->getDeliveryRules());
    }


    /**
     * @return array
     */
    protected function getDeliveryRules()
    {
        $delivery_method = DeliveryMethod::find(request('delivery_method_id'));

        $rules = [

        ];

        switch ($delivery_method->type) {

            case 'in_moscow' :
                $rules = [
                    'delivery-'.$delivery_method->id.'-address' => 'required|string|max:190',
                    'delivery-'.$delivery_method->id.'-time' => 'required_without:is_mobile|string|max:190',
                ];
                break;

            case 'in_russia' :
                $rules = [
                    'delivery-'.$delivery_method->id.'-address' => 'required|string|max:190',
                    'delivery-'.$delivery_method->id.'-custom_company' => 'required_if:delivery-'.$delivery_method->id.'-company, "custom"'
                ];
                break;
        }

        return $rules;
    }
}
