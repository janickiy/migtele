<?php

namespace App\Model;


/**
 * App\Model\DeliveryMethod
 *
 * @property int $id
 * @property string $name
 * @property string $api_name
 * @property string $type
 * @property string|null $description
 * @property int|null $price
 * @property string|null $map_file
 * @property string|null $coordinate
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $days
 * @property string|null $hours
 * @property string|null $text_to_store
 * @property string|null $text_to_door
 * @property int|null $hide
 * @property int|null $sort
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\DeliveryMethodItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereCoordinate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereMapFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereTextToDoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereTextToStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereType($value)
 * @mixin \Eloquent
 * @property-read mixed $rules
 * @property string|null $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereFile($value)
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereApiName($value)
 */
class DeliveryMethod extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'type', 'price'];


    public function getCoordinateAttribute($value) {

        return $value ? explode(',', $value) : [55.6961298, 37.4930935];

    }

    public function getRulesAttribute() {

        $rules = [

        ];

        switch ($this->type) {

            case 'in_moscow' :
                $rules = [
                    'delivery-'.$this->id.'-address' => 'required',
                    'delivery-'.$this->id.'-time' => 'required_without:is_mobile',
                ];
                break;

            case 'in_russia' :
                $rules = [
                    'delivery-'.$this->id.'-address' => 'required',
                    'delivery-'.$this->id.'-custom_company' => 'required_if:delivery-'.$this->id.'-company, "custom"'
                ];
                break;

        }

        return $rules;
    }


    public function getImgAttribute() {

        $file_path = '/uploads/delivery/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';

    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(DeliveryMethodItem::class)->published()->sort();
    }


    /**
     * Scopes
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('hide', 0);
    }


    /**
     * Static helpers
     */


    public static function getDeliveryInfoInOrder()
    {
        $delivery_method = request('delivery_method_id') ? DeliveryMethod::find(request('delivery_method_id')) : '';

        $delivery_company_name = $delivery_method ? self::getDeliveryCompanyNameByDeliveryId($delivery_method->id) : '';

        $delivery_name = $delivery_method ? ($delivery_method->api_name ? $delivery_method->api_name : $delivery_method->name) : '';

        $delivery_full_name = $delivery_company_name ? $delivery_company_name : $delivery_name;

        return [
            'id' => request('delivery_method_id'),
            'name' => $delivery_name,
            'company_name' => $delivery_company_name,
            'full_name' => $delivery_full_name,
            'price' => $delivery_method ? $delivery_method->price : '',
            'address' => $delivery_method ? request('delivery-'.$delivery_method->id.'-address') : '',
            'time' => $delivery_method ? request('delivery-'.$delivery_method->id.'-time') : '',
            'note' => $delivery_method ? request('delivery-'.$delivery_method->id.'-note') : '',
            'to' => $delivery_method ? request('delivery-'.$delivery_method->id.'-to') : ''
        ];

    }


    public static function getDeliveryCompanyNameByDeliveryId($delivery_id){

        $delivery_company_id = request('delivery-'.$delivery_id.'-company');

        if(!$delivery_company_id)
            return '';

        if($delivery_company_id == 'custom')
            return request('delivery-'.$delivery_id.'-custom_company');

        $delivery_company = DeliveryMethodItem::find($delivery_company_id);

        return $delivery_company->name;

    }

}
