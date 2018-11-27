<?php

namespace App\Model;


/**
 * App\Model\Pages
 *
 * @property int $id
 * @property int $id_parent
 * @property string $name
 * @property string $link
 * @property string $text
 * @property int $top
 * @property int $mid
 * @property int $bot
 * @property int $sort
 * @property int $readonly
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereBot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereMid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereReadonly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereTop($value)
 * @mixin \Eloquent
 * @property-read mixed $banner
 * @property-read mixed $preview
 * @property int|null $is_advantage
 * @property int|null $advantage_order
 * @property string|null $advantage_description
 * @property string|null $advantage_title
 * @property-read mixed $advantage_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages advantages()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereAdvantageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereAdvantageOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereIsAdvantage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereAdvantageTitle($value)
 * @property-read mixed $is_special
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages specials()
 */
class Pages extends Model
{
    protected $table = 'pages';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'link',
        'text',
        'readonly',
        'top',
        'mid',
        'bot',
        'title',
        'keywords',
        'descriptions'
    ];

    public $special_list = ['/oferta.htm', '/zaschita_personalnih_dannih.htm'];

    /**
     * Accessors
     */

    public function getPreviewAttribute()
    {
        $file_path = '/uploads/pages/preview_'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }

    public function getBannerAttribute()
    {
        $file_path = '/uploads/pages/banner_'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }

    public function getAdvantageImageAttribute()
    {
        $file_path = '/uploads/advantages/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '';
    }

    public function getAdvantageTitleAttribute($value)
    {
        return $value ? $value : $this->name;
    }


    public function getTextAttribute($value)
    {
        return str_replace('[payment-form]', view('modules.payment-form'), $value);
    }


    public function getIsSpecialAttribute($value)
    {
        return in_array($this->link, $this->special_list);
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


    public function scopeAdvantages($query)
    {
        return $query->where('is_advantage', 1)->orderBy('advantage_order')->sort();
    }


    public function scopeSpecials($query)
    {
        return $query->whereIn('link', $this->special_list);
    }


}
