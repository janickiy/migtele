<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PromocodeUse
 *
 * @property int $id
 * @property string $email
 * @property string $used_at
 * @property int $promocode_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeUse whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeUse wherePromocodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeUse whereUsedAt($value)
 * @mixin \Eloquent
 */
class PromocodeUse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email', 'promocode_id', 'used_at'
    ];


    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

}
