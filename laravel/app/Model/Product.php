<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

/**
 * App\Model\Product
 *
 * @property int $id
 * @property int $id_cattmr
 * @property int $id_catsr
 * @property string $kod
 * @property string|null $kod2
 * @property string $name
 * @property string $link
 * @property string $text1 краткое описание товара
 * @property string $text2 основное описание товара
 * @property string $text3 текст в правой колонке
 * @property string $text4 описание при выводе похожих и сопутствующих товаров
 * @property string $text5 текст в самом низу страницы товара
 * @property string $teh
 * @property string $feature1
 * @property string $feature2
 * @property float $price
 * @property string $valuta
 * @property int $new новинка
 * @property int $yml
 * @property string $sp срок поставки
 * @property int $none снято с производства
 * @property string $soft
 * @property int $hide
 * @property int $sort
 * @property string $tr
 * @property int $sort_tr
 * @property int $nalich
 * @property string $ids_goods
 * @property int $valid
 * @property int $price_markup
 * @property int|null $importNew
 * @property int|null $clickCount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereFeature1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereFeature2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereIdCatsr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereIdCattmr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereIdsGoods($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereImportNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereKod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereKod2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereNalich($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereNone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSoft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSortTr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereTeh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereText1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereText2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereText3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereText4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereText5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereTr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereValuta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereYml($value)
 * @mixin \Eloquent
 * @property-read mixed $economy_price
 * @property-read mixed $old_price
 * @property-read mixed $preview
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductImages[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product categoryIds($category_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product popular()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product sessionSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product sortExchangeToRub($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product wherePriceMarkup($value)
 * @property-read mixed $cart_discount
 * @property-read mixed $cart_price
 * @property-read mixed $discount_original
 * @property-read mixed $keywords
 * @property-read mixed $quantity
 * @property-read string $short_description
 * @property-read string $title
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\ProductImages[] $images_ids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product priceRange()
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Model\Cattmr $cattmr
 * @property-read mixed $category
 * @property-read mixed $sub_category
 * @property-read mixed $sub_category_url
 * @property-read mixed $vendor
 * @property-read mixed $vendor_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product new()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereUpdatedAt($value)
 * @property string|null $delivery_text
 * @property string|null $warranty_text
 * @property-read mixed $in_wish_list
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereWarrantyText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $interested_products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product limitId($limit)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product related($product_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product search($search_text)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product sortBySubCategory()
 * @property int $sale
 * @property-read mixed $vendor_discount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product sales()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product whereSale($value)
 * @property-read mixed $sub_category2
 * @property-read mixed $sub_category2_url
 * @property-read mixed $is_new
 * @property-read mixed $original_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Product catalogNew()
 */
class Product extends Model
{
    protected $table = 'goods';
    //public $timestamps = false;

    public function toArray()
    {
        $array = parent::toArray();
        $array['preview'] = $this->preview;
        return $array;
    }

    public function getMorphClass()
    {
        return 'product';
    }


    /**
     * Relations
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images_ids()
    {
        return $this->hasMany(ProductImages::class, 'id_goods', 'id');
    }

    public function cattmr()
    {
        return $this->belongsTo(Cattmr::class, 'id_cattmr');
    }


    /**
     * Accessors
     */


    public function getInterestedProductsAttribute()
    {

        $product_category_ids = Cattmr::published()->where('id_catmaker', $this->vendor->id)->where('id_cattype', $this->category->id)->pluck('id');

        $price_from = $this->getOriginal('price') / 1.5;
        $price_to = $this->getOriginal('price') * 1.5;

        return Product::categoryIds($product_category_ids)
            ->priceRange($price_from, $price_to)
            ->whereNotIn('goods.id', [$this->id])
            ->limit(10)->get();
    }


    /**
     * @return string
     */
    public function getPreviewAttribute()
    {
        $image = $this->images_ids()->sort()->first();

        return $image ? $image->id : 'no-photo';
    }

    public function getOriginalImageAttribute()
    {
        return url('/images/original/uploads/goods_img/'. $this->preview.'.jpg');
    }

    public function getImagesAttribute()
    {
        $image_urls = [];

        foreach ($this->images_ids()->sort()->get() as $image) {

            $image_urls[] = '/images/gallery/uploads/goods_img/'.$image->id.'.jpg';

        }

        return $image_urls;
    }

    /**
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return _price($this->getCorrectPrice($value));
    }

    /**
     * @param $value
     * @return string
     */
    public function getOldPriceAttribute($value)
    {
        return _price($this->getCorrectPrice($this->getOldPrice()));
    }

    /**
     * @param $value
     * @return string
     */
    public function getEconomyPriceAttribute($value)
    {
        return _price($this->discount_original);
    }

    /**
     * @return boolean
     */
    public function getInWishListAttribute()
    {
        return \WishlistProducts::exist($this->id);
    }


    /**
     * @return mixed
     */
    public function getQuantityAttribute()
    {
        if(session('clone_products')){
            $quantity = 1;
            foreach (session('clone_products') as $clone_product){
                if($clone_product['id'] == $this->id){
                    $quantity = $clone_product['quantity'];
                    break;
                }
            }

            return $quantity;
        }
        return \CartProducts::getQuantity($this->id);
    }


    public function getVendorDiscountAttribute()
    {

        if(!$this->vendor) return 0;

        $discount = $this->vendor->discounts_reverse()->where('quantity', '<=', $this->quantity)->first();

        $price = $this->getCorrectPrice();

        return $discount ? $price * $discount->value / 100 : 0;
    }

    public function getPromocodeDiscountAttribute()
    {
        $promocode = \Promocodes::getSessionPromocode();
        if(!$promocode) return 0;

        $price = $this->getCorrectPrice();

        return $price * $promocode->reward / 100;
    }

    public function getCartPriceAttribute()
    {
        $price = $this->getCorrectPrice();

        return $price - $this->vendor_discount - $this->promocode_discount;
    }

    public function getCartDiscountAttribute()
    {
        return $this->discount_original + $this->vendor_discount + $this->promocode_discount;
    }


    public function getCategoryAttribute()
    {
        return $this->cattmr ? $this->cattmr->category : '';
    }

    public function getSubCategoryAttribute()
    {
        return $this->cattmr ? $this->cattmr->sub_category : '';
    }

    public function getSubCategory2Attribute()
    {
        return $this->cattmr ? $this->cattmr->sub_category2 : '';
    }

    public function getVendorAttribute()
    {
        return $this->cattmr ? $this->cattmr->vendor : '';
    }

    public function getSubCategoryUrlAttribute()
    {
        return $this->category && $this->sub_category ? $this->category->getUrlWithSubcategory($this->sub_category) : '';
    }

    public function getSubCategory2UrlAttribute()
    {
        return $this->category && $this->sub_category2 ? $this->category->getUrlSubcategory2($this->sub_category, $this->sub_category2) : '';
    }

    public function getVendorUrlAttribute()
    {
        return $this->vendor ? $this->vendor->url  : '';
    }


    /**
     * @param $value
     * @return integer
     */
    public function getDiscountOriginalAttribute($value)
    {
        return $this->getCorrectPrice($this->getOldPrice() - $this->getOriginal('price'));
    }

    /**
     * @param $value
     * @return string
     */
    public function getShortDescriptionAttribute($value)
    {
        return str_limit(strip_tags($this->text1), 95);
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return '/tovar/'.$this->link.'.htm';
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->name.' | Купить по низкой цене с доставкой по РФ';
    }

    public function getKeywordsAttribute()
    {
        return $this->name;
    }

    public function getIsNewAttribute()
    {
        return $this->created_at->timestamp > strtotime("-3 month");
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
        return $query->where('goods.hide', 0)->where('goods.importNew', 0)->where('goods.id_cattmr', '<>', 0)
            ->join('cattmr', 'goods.id_cattmr', '=', 'cattmr.id')
            ->join('cattype', 'cattmr.id_cattype', '=', 'cattype.id')
            ->join('catmaker', 'cattmr.id_catmaker', '=', 'catmaker.id')
            ->join('catrazdel', 'cattmr.id_catrazdel', '=', 'catrazdel.id')
            ->where('cattmr.hide', 0)
            ->where('cattype.status', 1)
            ->where('catmaker.hide', 0)
            ->where('catrazdel.hide', 0)
            ->where(function($query){

                $query->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('catrazdel')
                        ->whereRaw(env('DB_PREFIX').'catrazdel.id = '.env('DB_PREFIX').'cattmr.id_sub_catrazdel')
                        ->where('catrazdel.hide', 0);
                });

                $query->orWhere('cattmr.id_sub_catrazdel', 0);
                $query->orWhereNull('cattmr.id_sub_catrazdel');
            })
            ->addSelect(['goods.*']);
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        return $query->orderBy('goods.clickCount', 'DESC');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNew($query)
    {
        return $query->orderBy('goods.created_at', 'DESC')->orderBy('goods.new', 'DESC')->orderBy('goods.id', 'DESC');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCatalogNew($query)
    {
        return $query->where('goods.created_at', '>=', date('Y-m-d', strtotime("-3 month")));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSessionSort($query)
    {
        $order_by = [
            'column' => 'clickCount',
            'direction' => 'asc'
        ];

        switch (getSortName()){

            case 'popular_asc':
                $order_by = [
                    'column' => 'goods.clickCount',
                    'direction' => 'asc'
                ];
                break;

            case 'popular_desc':
                $order_by = [
                    'column' => 'goods.clickCount',
                    'direction' => 'desc'
                ];
                break;

            case 'price_asc':
                return $query->sortExchangeToRub();
                break;

            case 'price_desc':
                return $query->sortExchangeToRub('desc');
                break;
        }

        return $query->orderBy($order_by['column'], $order_by['direction']);

    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $category_ids
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategoryIds($query, $category_ids)
    {

        return $category_ids ? $query->whereIn('goods.id_cattmr', $category_ids) : $query;
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSales($query)
    {
        return $query->where('goods.sale', 1);
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortExchangeToRub($query, $direction = 'asc')
    {
        $sql = DB::raw($this->getSqlPriceExchange() . ' as price_sort');

        return $query->addSelect([$sql])->orderBy('price_sort', $direction);

    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $from
     * @param $to
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopePriceRange($query, $from = 0, $to = 0)
    {
        $from = $from ? $from : Input::get('from');
        $to = $to ? $to : Input::get('to');

        if ($from || $to){


            $sql = DB::raw($this->getSqlPriceExchange());

            return $query->where($sql, '>=', $from)->where($sql, '<=', $to);
        }
        else{
            return $query;
        }

    }

    public function scopeLimitId($query, $limit)
    {

        return $query->published()
            ->limit($limit)
            ->pluck('id');
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $product_id
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeRelated($query, $product_id)
    {

        $product = self::whereId($product_id)->first();


        $product_ids = [0, $product_id];


        $product_ids = array_merge(Product::where('id_cattmr', $product->id_cattmr)->whereNotIn('id', $product_ids)->popular()->limit(2)->pluck('id')->toArray(), $product_ids);

        $cattmr_ids = Cattmr::categories($product->cattmr->id_cattype, $product->cattmr->id_catrazdel, $product->cattmr->id_sub_catrazdel)->whereNotIn('id_catmaker', [$product->cattmr->id_catmaker])->pluck('id');

        if(count($cattmr_ids))
            $product_ids = array_merge($product_ids, Product::whereIn('id_cattmr', $cattmr_ids)->whereNotIn('id', $product_ids)->popular()->limit(4)->pluck('id')->toArray());


        $cattmr_ids = Cattmr::categories($product->cattmr->id_cattype, $product->cattmr->id_catrazdel, $product->cattmr->id_sub_catrazdel)->pluck('id');

        $product_ids = array_merge($product_ids, Product::whereIn('id_cattmr', $cattmr_ids)->whereNotIn('id', $product_ids)->popular()->pluck('id')->toArray());


        $ids_ordered = implode(',', $product_ids);

        return count($product_ids) ? $query->whereIn('goods.id', $product_ids)->whereNotIn('goods.id', [$product->id])->orderByRaw(\DB::raw("FIELD(".env('DB_PREFIX')."goods.id, $ids_ordered)")) : $query;

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
                    ->where('kod', 'like', $search_text)
                    ->orWhere('goods.name', 'like', $search_text)
                    ->orWhere('goods.text1', 'like', $search_text)
                    ->orWhere('goods.text2', 'like', $search_text)
                    ->orWhere('goods.text3', 'like', $search_text);
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortBySubCategory($query)
    {

        return $query->orderBy('cattmr.id_catrazdel');
    }



    /**
     * Helpers
     */

    /**
     * @param $value
     * @return mixed
     */
    public function getCorrectPrice($value = null) {

        $value = is_null($value) ? $this->getOriginal('price') : $value;

        $value = $this->valuta == "rub" ? $value : $value * ExchangeRate::getRate($this->valuta);

        return round($value, 0);

    }

    /**
     * @return array|mixed
     */
    public function getOldPrice() {

        $price = $this->getOriginal('price');

        return $price + ($price * $this->price_markup / 100);

    }

    public function getSqlPriceExchange() {

        $eur = ExchangeRate::getRate('eur');
        $usd = ExchangeRate::getRate('usd');

        return env('DB_PREFIX').'goods.price * (CASE WHEN valuta = "eur" THEN '.$eur.' WHEN valuta = "usd" THEN '.$usd.' ELSE 1 END)';
    }




    /**
     * Static Helpers
     *
     */

    /**
     * @param $category_ids
     * @param $is_popular
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getCatalog($category_ids = '')
    {
        return self::categoryIds($category_ids)->published()->priceRange()->sessionSort()->distinct()->paginate(getPageSize());
    }

    /**
     * @param $category_ids
     * @return array
     */
    public static function getPriceRange($category_ids = '')
    {

        /**
         * @var $from Product
         * @var $to Product
         */
        $from = self::categoryIds($category_ids)->published()->sortExchangeToRub()->first();
        $to = self::categoryIds($category_ids)->published()->sortExchangeToRub('desc')->first();

        return array(
            'from' => $from ? $from->getCorrectPrice() : 0,
            'to' => $to ? $to->getCorrectPrice() : 0

        );

    }

    /**
     * @return int
     */
    public static function getAllCartDiscount()
    {
        $discount = 0;
        $products = self::whereIn('goods.id', \CartProducts::all())->published()->get();

        foreach ($products as $product) {

            $discount += $product->cart_discount * $product->quantity;

        }

        return $discount;
    }


    public static function getCartProduct()
    {
        return Product::whereIn('goods.id', \CartProducts::all())->published()->get();
    }

    public function setCount()
    {
        $this->clickCount++;
        $this->save();
    }

}
