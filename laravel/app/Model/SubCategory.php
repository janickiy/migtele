<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * App\Model\SubCategory
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $text
 * @property int $hide
 * @property int $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int|null $clickCount
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SubCategory published()
 */
class SubCategory extends Model
{
    protected $table = 'catrazdel';

    public $timestamps = false;

    public function getMorphClass()
    {
        return 'sub_category';
    }

    /**
     * Relationship
     */

    /**
     * @param $category_id
     * @return BelongsToMany
     */
    public function vendors($category_id)
    {
        return $this->belongsToMany(Vendor::class, 'cattmr', 'id_catrazdel', 'id_catmaker')
            ->where([
                'catmaker.hide' => 0,
                'cattmr.id_cattype' => $category_id,
                'cattmr.hide' => 0
            ])
            ->orderBy('name');
    }

    public function sub_category_vendors($category_id, $sub_category_id)
    {
        return $this->belongsToMany(Vendor::class, 'cattmr', 'id_sub_catrazdel', 'id_catmaker')
            ->where([
                'catmaker.hide' => 0,
                'cattmr.id_cattype' => $category_id,
                'cattmr.id_catrazdel' => $sub_category_id,
                'cattmr.hide' => 0
            ])
            ->orderBy('name');
    }


    public function sub_categories2($category_id, $vendor_id = null)
    {
        $query = $this->belongsToMany(SubCategory::class, 'cattmr', 'id_catrazdel', 'id_sub_catrazdel')
            ->where([
                'catrazdel.hide' => 0,
                'cattmr.id_cattype' => $category_id,
                'cattmr.hide' => 0
            ])
            ->orderBy('in_last_order', 'ASC')
            ->orderBy('name');

        if($vendor_id){
            $query = $query->where('cattmr.id_catmaker', $vendor_id);
        }

        return $query;
    }

    public function sub_cattmr()
    {
        return $this->hasMany(Cattmr::class, 'id_sub_catrazdel');
    }

    public function cattmr()
    {
        return $this->hasMany(Cattmr::class, 'id_catrazdel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sliders()
    {
        return $this->morphToMany(Slider::class, 'entity', 'entity_slider')->published()->sort();
    }


    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cattmr', 'id_catrazdel', 'id_cattype');

    }


    public function tags()
    {
        return $this->hasMany(Tag::class, 'subcategory_id');
    }


    public function getContentTitleAttribute($value)
    {
        return $value ? $value : $this->name;
    }

    public function getCategoryAttribute()
    {
        return $this->categories[0];
    }


    public function getImgAttribute()
    {
        $file_path = '/uploads/catrazdel/'.$this->id.'.jpg';

        return @file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$file_path) ? $file_path : '/static/img/noimage.png';
    }

    public function getUrlAttribute()
    {

        if(count($this->sub_cattmr)){
            $cattmr = $this->sub_cattmr[0];

            return $cattmr->category->getUrlSubcategory2($cattmr->sub_category, $cattmr->sub_category2);

        }elseif (count($this->cattmr)){

            $cattmr = $this->cattmr[0];

            return $cattmr->category->getUrlWithSubcategory($cattmr->sub_category);

        }

        return null;

    }


    /**
     * Helpers
     */


    public function getInterestedProductsAttribute()
    {

        $product_category_ids = $this->category->product_category_ids;

        return Product::categoryIds($product_category_ids)
            ->inRandomOrder()
            ->limit(10)->get();
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIdsAttribute()
    {
        return DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catmaker', 'catmaker.id', '=', 'cattmr.id_catmaker')
            ->where([
                'cattmr.id_catrazdel' => $this->id,
                'cattmr.hide' => 0,
                'catmaker.hide' => 0,
            ])->pluck('id');

    }


    /**
     * @param $category_id
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIds($category_id)
    {
        return DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catmaker', 'catmaker.id', '=', 'cattmr.id_catmaker')
            ->where([
                'cattmr.id_cattype' => $category_id,
                'cattmr.id_catrazdel' => $this->id,
                'cattmr.hide' => 0,
                'catmaker.hide' => 0,
            ])->pluck('id');

    }

    /**
     * @param $category_id
     * @return \Illuminate\Support\Collection
     */
    public function getProductCategoryIds2($category_id, $sub_category_id)
    {
        return DB::
        table('cattmr')
            ->select('cattmr.id')
            ->join('catmaker', 'catmaker.id', '=', 'cattmr.id_catmaker')
            ->where([
                'cattmr.id_cattype' => $category_id,
                'cattmr.id_catrazdel' => $sub_category_id,
                'cattmr.id_sub_catrazdel' => $this->id,
                'cattmr.hide' => 0,
                'catmaker.hide' => 0,
            ])->pluck('id');

    }

    
    /**
     * Scopes
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('hide', 0);
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
            ->where('name', 'like', $search_text)
            ->orWhere('text', 'like', $search_text)
            ->orWhere('title', 'like', $search_text)
            ->orWhere('description', 'like', $search_text)
            ->orWhere('keywords', 'like', $search_text);
    }


    public static function getProductsWithSubCategories($product_ids)
    {
        $products = Product::whereIn('goods.id', $product_ids)->sortBySubCategory()->published()->get();


        return self::chunkWithSubCategories($products);

    }

    public static function chunkWithSubCategories($products)
    {
        $sub_categories = [];

        foreach ($products as $product)
        {
            if($product->sub_category)
                $sub_categories[$product->sub_category->name][] = $product;
        }

        return $sub_categories;
    }

    public function setCount()
    {
        $this->clickCount++;
        $this->save();
    }

}
