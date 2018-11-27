<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model{
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
	class CallOrder extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Category
 *
 * @property int $id
 * @property int $id_otr
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property string $feature
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $status
 * @property int|null $clickCount
 * @property string $slug
 * @property string $url
 * @property string $warranty_text
 * @property string $delivery_text
 * @property array $product_category_ids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereIdOtr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereTitle($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\SubCategory[] $sub_categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category mainSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category published()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Vendor[] $vendors
 * @property string|null $banner_url
 * @property-read mixed $banner_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category industry($id_otr)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereBannerUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Category whereWarrantyText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $interested_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Slider[] $sliders
 * @property-read \App\Model\Otrasl $otrasl
 */
	class Category extends \Eloquent {}
}

namespace App\Model{
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
 */
	class Cattmr extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\DeliveryMethod
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property int|null $price
 * @property string|null $map_file
 * @property string|null $coordinate
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $days
 * @property string|null $hours
 * @property string|null $text_to_store
 * @property string|null $text_to_door
 * @property int|null $hide
 * @property int|null $sort
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\DeliveryMethodItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereCoordinate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereMapFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereTextToDoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereTextToStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereType($value)
 * @mixin \Eloquent
 * @property-read mixed $rules
 * @property string|null $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethod whereFile($value)
 * @property-read mixed $img
 */
	class DeliveryMethod extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\DeliveryMethodItem
 *
 * @property int $id
 * @property int $delivery_method_id
 * @property string $name
 * @property string|null $description
 * @property int|null $hide
 * @property int|null $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereDeliveryMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\DeliveryMethodItem whereSort($value)
 * @mixin \Eloquent
 */
	class DeliveryMethodItem extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ExchangeRate
 *
 * @property int $id
 * @property string $date
 * @property float $usd
 * @property float $eur
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereEur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ExchangeRate whereUsd($value)
 * @mixin \Eloquent
 */
	class ExchangeRate extends \Eloquent {}
}

namespace App\Model{
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
	class MailTemplate extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\News
 *
 * @property int $id
 * @property string $date
 * @property string $name
 * @property string $text1
 * @property string $text2
 * @property-read mixed $description
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereText1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\News whereText2($value)
 * @mixin \Eloquent
 */
	class News extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Order
 *
 * @property int $id
 * @property string $date
 * @property string $order_info
 * @property string $user_info
 * @property string|null $delivery_info
 * @property float $itogo
 * @property string|null $notes
 * @property string $status
 * @property string $number
 * @property string $delivery_name
 * @property integer $delivery_price
 * @property string $api_status
 * @property boolean $cancel
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereItogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereOrderInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUserInfo($value)
 * @mixin \Eloquent
 * @property int|null $user_id
 * @property int|null $notify_on_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNotifyOnStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereUserId($value)
 * @property int|null $payment_method_id
 * @property int|null $delivery_method_id
 * @property-read \App\Model\DeliveryMethod $delivery_method
 * @property-read mixed $amount
 * @property-read bool $is_new
 * @property-read \App\Model\PaymentMethod $payment_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order wherePaymentMethodId($value)
 * @property string|null $order_file_url
 * @property string|null $shipping_file_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereOrderFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereShippingFileUrl($value)
 * @property int|null $contractor_type
 * @property string|null $contractor_name
 * @property string|null $contractor_phone
 * @property string|null $contractor_email
 * @property string|null $contractor_address
 * @property string|null $contractor_company_name
 * @property string|null $contractor_organization
 * @property string|null $contractor_inn
 * @property string|null $contractor_companyReciever
 * @property string|null $contractor_companyRecieverAddress
 * @property string|null $contractor_bankTotal
 * @property string|null $deliveryAddress
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereApiStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorBankTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyReciever($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorCompanyRecieverAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereContractorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereDeliveryAddress($value)
 * @property-read mixed $default_delivery_method
 * @property-read mixed $default_delivery_method_id
 * @property-read mixed $default_delivery_name
 * @property-read mixed $default_delivery_price
 * @property-read \PaymentMethod $default_payment_method
 * @property-read int $default_payment_method_id
 * @property-read string $default_payment_method_name
 * @property-read mixed $discount
 * @property-read string $payment_method_name
 * @property-read mixed $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereCancel($value)
 * @property-read mixed $delivery_img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order whereComment($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\OrderProduct
 *
 * @property int $id
 * @property int $id_order
 * @property int $id_good
 * @property float $price
 * @property int $kol
 * @property float $stoim
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereIdGood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereIdOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereKol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\OrderProduct whereStoim($value)
 * @mixin \Eloquent
 */
	class OrderProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Otrasl
 *
 * @property int $id
 * @property int $id_gr
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $status
 * @property int|null $clickCount
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereIdGr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Otrasl whereTitle($value)
 * @mixin \Eloquent
 * @property-read mixed $url
 */
	class Otrasl extends \Eloquent {}
}

namespace App\Model{
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
 * @property-read mixed $advantage_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages advantages()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereAdvantageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereAdvantageOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Pages whereIsAdvantage($value)
 */
	class Pages extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $type
 * @property int|null $sort
 * @property int|null $hide
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\PaymentMethodItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethod whereType($value)
 * @mixin \Eloquent
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\PaymentMethodItem
 *
 * @property int $id
 * @property int $payment_method_id
 * @property string|null $name
 * @property int|null $sort
 * @property int|null $hide
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\PaymentMethodItem whereSort($value)
 * @mixin \Eloquent
 */
	class PaymentMethodItem extends \Eloquent {}
}

namespace App\Model{
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
 */
	class Product extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\ProductImages
 *
 * @property int $id
 * @property int $id_goods
 * @property string $text
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereIdGoods($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\ProductImages whereText($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Product $product
 */
	class ProductImages extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Setting
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $value
 * @property int $sort
 * @property int $hide
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Slider
 *
 * @property int $id
 * @property string $name
 * @property string|null $url
 * @property int|null $sort
 * @property int|null $in_homepage
 * @property int|null $hide
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider homepage()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider sort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereInHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Slider whereUrl($value)
 * @mixin \Eloquent
 */
	class Slider extends \Eloquent {}
}

namespace App\Model\Statistic{
/**
 * App\Model\Statistic\VisitAll
 *
 * @property string $date
 * @property int $unic
 * @property int $whole
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereUnic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitAll whereWhole($value)
 * @mixin \Eloquent
 */
	class VisitAll extends \Eloquent {}
}

namespace App\Model\Statistic{
/**
 * App\Model\Statistic\VisitDay
 *
 * @property string $ip
 * @property string $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Statistic\VisitDay whereIp($value)
 * @mixin \Eloquent
 */
	class VisitDay extends \Eloquent {}
}

namespace App\Model{
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
	class Subscriber extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $hide
 * @property Category $category
 * @property SubCategory $sub_category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereSlug($value)
 * @mixin \Eloquent
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property string|null $text
 * @property string|null $delivery_text
 * @property string|null $warranty_text
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tag whereWarrantyText($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\TagItem
 *
 * @property int $id
 * @property int $tag_id
 * @property int $entity_id
 * @property string $entity_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TagItem whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TagItem whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TagItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TagItem whereTagId($value)
 * @mixin \Eloquent
 */
	class TagItem extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @property string $type
 * @property string|null $company_name
 * @property string|null $tin
 * @property string|null $juridical_address
 * @property string|null $actual_address
 * @property string|null $phones
 * @property string|null $delivery_addresses
 * @property string|null $passport
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereActualAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereDeliveryAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereDeliveryAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereJuridicalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNewsSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNotificationInEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereType($value)
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order[] $orders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNotifyOnStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribe($value)
 * @property-read mixed $delivery_address
 * @property-read mixed $phone
 * @property int $subscribe_order
 * @property int $subscribe_cart
 * @property int $subscribe_view
 * @property int $subscribe_wishlist
 * @property int $subscribe_news
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeNews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSubscribeWishlist($value)
 * @property string|null $last_activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $cart_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $view_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $wishlist_products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLastActivity($value)
 */
	class User extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\UserCartProduct
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property int $ordered
 * @property int $send
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserCartProduct whereUserId($value)
 * @mixin \Eloquent
 */
	class UserCartProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\UserViewProduct
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $send
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserViewProduct whereUserId($value)
 * @mixin \Eloquent
 */
	class UserViewProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\UserWishlistProduct
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $send
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserWishlistProduct whereUserId($value)
 * @mixin \Eloquent
 */
	class UserWishlistProduct extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Vendor
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $text
 * @property int $sort
 * @property int $hide
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int|null $clickCount
 * @property int $hide_in_YML
 * @property string $slug
 * @property string $url
 * @property string $delivery_text
 * @property string $warranty_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereClickCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereHideInYML($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereTitle($value)
 * @property-read mixed $img
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor mainSort()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor published()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\SubCategory[] $sub_categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor alphabet()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor char($char)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Product[] $interested_products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Slider[] $sliders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor sortRelatedVendors($sub_category_ids)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereDeliveryText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor whereWarrantyText($value)
 * @property-read mixed $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\VendorDiscount[] $discounts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\VendorDiscount[] $discounts_reverse
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vendor search($search_text)
 */
	class Vendor extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\VendorDiscount
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $value
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\VendorDiscount whereVendorId($value)
 */
	class VendorDiscount extends \Eloquent {}
}

