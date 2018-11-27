<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Promocode
 *
 * @property int $id
 * @property string $code
 * @property float|null $reward
 * @property int $quantity
 * @property string $expire_date
 * @property string $only_email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Promocode whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Promocode extends Model
{
    protected $fillable = [
        'code', 'reward', 'quantity', 'expire_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'expire_date'
    ];


    public function creator()
    {
        return $this->hasOne(PromocodeCreator::class);
    }

    /**
     * @param Builder $query
     * @param $code
     * @return Builder mixed
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }


    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expire_date) : false;
    }


    public function getUrlAttribute()
    {
        return route('promocode.share', ['code' => $this->code]);
    }




    public function getMailPatternsAttribute()
    {
        return [
            '[name]' => $this->creator->name,
            '[reward]' => $this->reward,
            '[link]' => "<a href='".$this->url."'>".$this->url."</a>"
        ];
    }


    public function getSeoTitleAttribute()
    {
        return 'Скидка '.$this->reward.'% для моих друзей!';
    }

    public function getSeoDescriptionAttribute()
    {
        return 'Рекомендую migtele.ru, дали скидку '.$this->reward.'% на покупки для моих друзей. Действует до '.$this->expire_date->format('d.m.Y');
    }

}
