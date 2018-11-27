<?php

namespace App\Model;


/**
 * App\Model\MailTemplate
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $subject
 * @property string $title
 * @property string|null $description
 * @property string|null $shortcodes
 * @property string $body
 * @property string|null $footer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereShortcodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\MailTemplate whereTitle($value)
 * @mixin \Eloquent
 */
class MailTemplate extends Model
{

    public $patterns = [];

    public $timestamps = false;

    protected $fillable = [
        'key',
        'name',
        'subject',
        'title',
        'description',
        'shortcodes',
        'body',
        'footer'
    ];


    public function getSubjectAttribute($value)
    {
        return $this->patternReplace($value);
    }

    public function getTitleAttribute($value)
    {
        return $this->patternReplace($value);
    }

    public function getDescriptionAttribute($value)
    {
        return $this->patternReplace($value);
    }

    public function getBodyAttribute($value)
    {
        return $this->patternReplace($value);
    }

    public function getFooterAttribute($value)
    {
        return $this->patternReplace($value);
    }


    public function patternReplace($value)
    {
        foreach ($this->patterns as $key=>$pattern)
        {
            $value = str_replace($key, $pattern, $value);
        }

        return $value;
    }


}
