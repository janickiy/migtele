<?php

namespace App\Model;

use App\Models\Promocode;


/**
 * App\Model\Order
 *
 * @property int $id
 * @property string $date
 * @property string $order_info
 * @property string $user_info
 * @property string|null $delivery_info
 * @property float $itogo
 * @property string|null $notes
 * @property string $status
 * @property string $number
 * @property string $delivery_name
 * @property integer $delivery_price
 * @property string $api_status
 * @property boolean $cancel
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereItogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereOrderInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUserInfo($value)
 * @mixin \Eloquent
 * @property int|null $user_id
 * @property int|null $notify_on_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNotifyOnStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUserId($value)
 * @property int|null $payment_method_id
 * @property int|null $delivery_method_id
 * @property-read \App\Model\DeliveryMethod $delivery_method
 * @property-read mixed $amount
 * @property-read bool $is_new
 * @property-read \App\Model\PaymentMethod $payment_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order wherePaymentMethodId($value)
 * @property string|null $order_file_url
 * @property string|null $shipping_file_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereOrderFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereShippingFileUrl($value)
 * @property int|null $contractor_type
 * @property string|null $contractor_name
 * @property string|null $contractor_phone
 * @property string|null $contractor_email
 * @property string|null $contractor_address
 * @property string|null $contractor_company_name
 * @property string|null $contractor_organization
 * @property string|null $contractor_inn
 * @property string|null $contractor_companyReciever
 * @property string|null $contractor_companyRecieverAddress
 * @property string|null $contractor_bankTotal
 * @property string|null $deliveryAddress
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereApiStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorBankTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyReciever($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyRecieverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryAddress($value)
 * @property-read mixed $default_delivery_method
 * @property-read mixed $default_delivery_method_id
 * @property-read mixed $default_delivery_name
 * @property-read mixed $default_delivery_price
 * @property-read \PaymentMethod $default_payment_method
 * @property-read int $default_payment_method_id
 * @property-read string $default_payment_method_name
 * @property-read mixed $discount
 * @property-read string $payment_method_name
 * @property-read mixed $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereCancel($value)
 * @property-read mixed $delivery_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereComment($value)
 * @property int|null $contractor_id
 * @property-read \App\Model\Contractor|null $contractor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorId($value)
 */
class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'contractor_id',
        'payment_method_id',
        'delivery_method_id',
        'deliveryAddress',
        'delivery_name',
        'delivery_price',
        'date',
        'order_info',
        'user_info',
        'delivery_info',
        'itogo',
        'notes',
        'status',
        'notify_on_status',
        'number',
        'comment',
        'promocode_id'
    ];

    protected $dates = [
        'date'
    ];


    const DEFAULT_STATUS = 'новый';

    /**
     * Relationship
     */

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_goods', 'id_order', 'id_good')->withPivot(['price', 'kol', 'stoim', 'discount']);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function delivery_method()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }


    /**
     * Accessors
     */



    /**
     * @return bool
     */
    public function getIsNewAttribute()
    {
        return $this->status == 'новый' && $this->api_status ? strtolower($this->api_status) != 'отгружен' : true;
    }


    public function getNumberAttribute($value)
    {
        return $value ? $value : $this->id;
    }


    public function getAmountAttribute()
    {
        $amount = 0;

        foreach ($this->products as $product)
        {
            $amount += $product->pivot->stoim;
        }

        return $amount + $this->delivery_price;
    }

    public function getQuantityAttribute()
    {
        $quantity = 0;

        foreach ($this->products as $product)
        {
            $quantity += $product->pivot->kol;
        }

        return $quantity;
    }


    public function getDiscountAttribute()
    {
        $discount = 0;

        foreach ($this->products as $product)
        {
            $discount += $product->pivot->discount;
        }

        return $discount;
    }


    public function getContractorCompanyNameAttribute($value)
    {
        return !$value ? ' ' : $value;
    }

    /**
     * @return string
     */
    public function getPaymentMethodNameAttribute()
    {
        return $this->payment_method ? $this->payment_method->name : $this->default_payment_method_name;
    }

    /**
     * @return string
     */
    public function getDefaultPaymentMethodNameAttribute()
    {
        return $this->default_payment_method ? $this->default_payment_method->name : '';
    }

    /**
     * @return PaymentMethod
     */
    public function getDefaultPaymentMethodAttribute()
    {
        return PaymentMethod::sort()->first();
    }

    /**
     * @return int
     */
    public function getDefaultPaymentMethodIdAttribute()
    {
        return $this->default_payment_method ? $this->default_payment_method->id : 0;
    }


    public function getDeliveryNameAttribute($value)
    {
        return $value ? $value : ($this->delivery_method_id ? $this->delivery_method->name : $this->default_delivery_name);
    }

    public function getDeliveryImgAttribute($value)
    {
        return $this->delivery_method ? $this->delivery_method->img : '';
    }

    public function getDeliveryPriceAttribute($value)
    {
        return $value ? $value : ($this->delivery_method ? $this->delivery_method->price : $this->default_delivery_price);
    }

    public function getDeliveryAddressAttribute($value)
    {
        return $value ? $value : ($this->contractor ? $this->contractor->delivery_address : '');
    }

    public function getDefaultDeliveryMethodAttribute()
    {
        return DeliveryMethod::sort()->first();
    }

    public function getDefaultDeliveryNameAttribute()
    {
        return $this->default_delivery_method ? $this->default_delivery_method->name : '';
    }

    public function getDefaultDeliveryPriceAttribute()
    {
        return $this->default_delivery_method ? $this->default_delivery_method->price : '';
    }

    public function getDefaultDeliveryMethodIdAttribute()
    {
        return $this->default_delivery_method ? $this->default_delivery_method->id : 0;
    }





    /**
     * Scopes
     */


}

