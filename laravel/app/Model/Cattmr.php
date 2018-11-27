<?php

namespace App\Model;


/**
 * App\Model\Cattmr
 *
 * @property int $id
 * @property int $id_cattype
 * @property int $id_catmaker
 * @property int $id_catrazdel
 * @property string $text
 * @property string|null $text1
 * @property string|null $text2
 * @property string $text_hide
 * @property int $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $hg скрывать товары
 * @property int $sr разбивать по сериям
 * @property int|null $clickCount
 * @property int $hide_in_YML
 * @property int $hide
 * @property-read \App\Model\Category $category
 * @property-read \App\Model\SubCategory $sub_category
 * @property-read \App\Model\Vendor $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereHg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereHideInYML($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereIdCatmaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereIdCatrazdel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereIdCattype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereSr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereText1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereText2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereTextHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereTitle($value)
 * @mixin \Eloquent
 * @property string|null $content_title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereContentTitle($value)
 * @property int|null $id_sub_catrazdel
 * @property-read \App\Model\SubCategory $sub_category2
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr whereIdSubCatrazdel($value)
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr categories($id_cattype, $id_catrazdel, $id_sub_catrazdel)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cattmr search($search_text)
 */
class Cattmr extends Model
{
    protected $table = 'cattmr';


    public $timestamps = false;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'id_cattype');
    }

    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'id_catrazdel');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'id_catmaker');
    }


    public function sub_category2()
    {
        return $this->hasOne(SubCategory::class, 'id', 'id_sub_catrazdel');
    }

    public function scopePublished($query)
    {
        return $query->where('hide', 0);
    }

    public function setCount()
    {
        $this->clickCount++;
        $this->save();
    }


    /**
     * @param $query
     * @param $search_text
     * @return mixed
     */
    public function scopeSearch($query, $search_text)
    {
        if(!$search_text) return $query;

        $search_text = '%'.$search_text.'%';

        return $query
            ->where('text', 'like', $search_text)
            ->orWhere('title', 'like', $search_text)
            ->orWhere('description', 'like', $search_text)
            ->orWhere('keywords', 'like', $search_text);
    }


    public function scopeCategories($query, $id_cattype, $id_catrazdel, $id_sub_catrazdel)
    {
        return $query->where('id_cattype', $id_cattype)->where('id_catrazdel', $id_catrazdel)->where('id_sub_catrazdel', $id_sub_catrazdel);
    }


    public function getUrlAttribute()
    {

        if($this->sub_category2){
            return $this->category->getUrlSubcategory2($this->sub_category, $this->sub_category2, $this->vendor);

        }else{

            return $this->category->getUrlWithVendorAndSubcategory( $this->vendor, $this->sub_category);

        }

    }

}
