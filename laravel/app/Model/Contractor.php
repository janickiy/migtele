<?php

namespace App\Model;

/**
 * App\Model\Contractor
 *
 * @property int $id
 * @property string $type
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string|null $mobile_phone
 * @property string|null $address
 * @property string|null $organization
 * @property string|null $inn
 * @property string|null $company_receiver
 * @property string|null $company_receiver_address
 * @property string|null $fact_address
 * @property string|null $delivery_address
 * @property string|null $delivery_address_2
 * @property string|null $bank_total
 * @property string|null $passport_number
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereBankTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereCompanyReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereCompanyReceiverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereDeliveryAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereFactAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereMobilePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Contractor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contractor extends Model
{
    protected $fillable = [

        'type',
        'name',
        'email',
        'phone',
        'mobile_phone',
        'address',
        'organization',
        'inn',
        'company_receiver',
        'company_receiver_address',
        'fact_address',
        'delivery_address',
        'delivery_address_2',
        'bank_total',
        'passport_number'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

}
