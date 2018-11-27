<?php

namespace App\Model;
/**
 * App\Subscriber
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $unsubscriber_hash
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Subscriber whereUnsubscriberHash($value)
 */
class Subscriber extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'unsubscriber_hash'
    ];



    public static function getUnsubscriberUrlByEmail($email)
    {
        $sub = self::where('email', $email)->first();

        return '/unsubscriber/'.$sub->unsubscriber_hash;
    }

}
