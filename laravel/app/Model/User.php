<?php

namespace App\Model;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

/**
 * App\Model\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @property string $type
 * @property string|null $company_name
 * @property string|null $tin
 * @property string|null $juridical_address
 * @property string|null $actual_address
 * @property string|null $phones
 * @property string|null $delivery_addresses
 * @property string|null $passport
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereActualAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereDeliveryAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereJuridicalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNewsSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNotificationInEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereType($value)
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order[] $orders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNotifyOnStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribe($value)
 * @property-read mixed $delivery_address
 * @property-read mixed $phone
 * @property int $subscribe_order
 * @property int $subscribe_cart
 * @property int $subscribe_view
 * @property int $subscribe_wishlist
 * @property int $subscribe_news
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeWishlist($value)
 * @property string|null $last_activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $cart_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $view_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $wishlist_products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastActivity($value)
 * @property-read mixed $delivery_address2
 * @property-read mixed $phone2
 */
class User extends Authenticatable
{
    use Notifiable;

    const INDIVIDUAL_TYPE = '1';
    const JURIDICAL_TYPE = '0';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'email',
        'password',
        'name',
        'company_name',
        'tin',
        'juridical_address',
        'actual_address',
        'subscribe_cart',
        'subscribe_news',
        'subscribe_order',
        'subscribe_wishlist',
        'subscribe_cart',
        'subscribe_view',
        'phones',
        'delivery_addresses',
        'passport',
        'comment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('date', 'desc');
    }


    public function view_products()
    {
        return $this->belongsToMany(Product::class, 'user_view_products', 'user_id', 'product_id')->withPivot(['send']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function not_send_view_products()
    {
        return $this->view_products()->wherePivot('send', 0)->orderBy('user_view_products.id', 'DESC');
    }

    public function wishlist_products()
    {
        return $this->belongsToMany(Product::class, 'user_wishlist_products', 'user_id', 'product_id');
    }

    public function not_send_wishlist_products()
    {
        return $this->wishlist_products()->wherePivot('send', 0)->orderBy('user_wishlist_products.id', 'DESC');
    }

    public function cart_products()
    {
        return $this->belongsToMany(Product::class, 'user_cart_products', 'user_id', 'product_id')->withPivot('quantity');
    }

    public function not_send_cart_products()
    {
        return $this->cart_products()->wherePivot('send', 0)->orderBy('user_cart_products.id', 'DESC');
    }


    /**
     * Accessors
     */

    /**
     * @param $value
     */
    public function setPhonesAttribute($value)
    {
        $this->attributes['phones'] = json_encode($value);
    }

    public function setDeliveryAddressesAttribute($value)
    {
        $this->attributes['delivery_addresses'] = base64_encode(serialize($value));
    }


    public function getPhonesAttribute($value)
    {
        return $value ? json_decode($value) : [''];
    }

    public function getDeliveryAddressesAttribute($value)
    {

        $value = unserialize(base64_decode($value));

        return count($value) ? $value : [''];
    }

    public function getPhoneAttribute()
    {
        return isset($this->phones[0]) ? $this->phones[0] : '';
    }


    public function getDeliveryAddressAttribute()
    {
        return isset($this->delivery_addresses[0]) ? $this->delivery_addresses[0] : '';
    }

    public function getPhone2Attribute()
    {
        return isset($this->phones[1]) ? $this->phones[1] : '';
    }


    public function getDeliveryAddress2Attribute()
    {
        return isset($this->delivery_addresses[1]) ? $this->delivery_addresses[1] : '';
    }


    /**
     * Static
     */

    /**
     * @param $type
     * @param $with_captcha
     * @param $is_edit
     * @param $user_id
     * @return array
     */
    public static function getValidatorRulesOnType($type, $with_captcha, $is_edit = false, $user_id = 0)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phones.0' => 'required'

        ];

        if($is_edit){

            $rules = array_merge($rules, [
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user_id),
                ],
            ]);

        }else{
            $rules = array_merge($rules, [
                'password' => 'required|string|min:3',
                'email' => 'required|string|email|max:255|unique:users',
            ]);

        }


        if ($with_captcha) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|captcha'
            ]);
        }

        switch ($type){

            case self::INDIVIDUAL_TYPE:

                $rules = array_merge($rules, [
                    'delivery_addresses.0' => 'required'
                ]);

                break;

            case self::JURIDICAL_TYPE:

                $rules = array_merge($rules, [
                    'company_name' => 'required|string|max:255',
                    'tin' => 'required|string|max:255',
                    'juridical_address' => 'required|string|max:255',
                    'actual_address' => 'required|string|max:255',
                ]);

                if(!$is_edit){
                    $rules = array_merge($rules, [
                        'juridical_delivery_address' => 'required|string|max:255'
                    ]);

                }

                break;
        }

        return $rules;

    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

}
