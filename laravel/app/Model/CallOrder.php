<?php

namespace App\Model;


/**
 * App\Model\CallOrder
 *
 * @property int $id
 * @property string $name
 * @property string $org
 * @property string $phone
 * @property string $mail
 * @property string $notes
 * @property string $date
 * @property integer $product_id
 * @property integer $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereOrg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder wherePhone($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\CallOrder whereProductsCount($value)
 */
class CallOrder extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name',
        'org',
        'phone',
        'mail',
        'notes',
        'date',
        'product_id',
        'products_count'
    ];

    protected $dates = ['date'];






}
