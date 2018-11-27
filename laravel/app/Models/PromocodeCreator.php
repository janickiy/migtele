<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PromocodeCreator
 *
 * @property int $id
 * @property string $email
 * @property int $promocode_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeCreator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeCreator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PromocodeCreator wherePromocodeId($value)
 * @mixin \Eloquent
 */
class PromocodeCreator extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'email', 'name', 'promocode_id'
    ];


    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

}
