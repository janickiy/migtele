<?php

namespace App\Http\Controllers;

use App\Model\Cattmr;
use App\Model\Product;

class GoogleFeedController
{ 
    private $tags;

    public function __invoke()
    {
        return response()->stream(function () {
            
            $filepath  = $_SERVER['DOCUMENT_ROOT'] . '/google_feed.xml';
            $cacheTime = 60 * 60 * 3;

            if (!file_exists($filepath) || filemtime($filepath) + $cacheTime <= time()) {
                $this->writeFeed($filepath);
            }
            
            readfile($filepath);

        }, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    protected function writeFeed($filepath)
    {
        $fp = fopen($filepath, 'w');
        flock($fp, LOCK_EX);

        $this->writeChannel($fp);
        $this->writeItems($fp);
        
        fwrite($fp, '</channel></rss>'.PHP_EOL);
        
        fwrite($fp, sprintf(
            '<!-- %.2f -->%s',
            microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
            PHP_EOL
        ));

        flock($fp, LOCK_UN);
        fclose($fp);
    }

    protected function writeChannel($file)
    {
        $this->tags = [
            'title' => static::sanitize(_setting('google-merchant-feed-name')),
            'description' => static::sanitize(_setting('google-merchant-feed-description')),
            'link' => env('APP_URL')
        ];

        return fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
            .'<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">'
            .'<channel>'.$this->getComposedTags());
    }

    protected function writeItems($file)
    {
        foreach ($this->getProducts() as $product) {
            $this->tags = [
                'g:id' => $product->id,
                'g:title' => $this->getProductTitle($product),
                'g:description' => $this->getProductDescription($product),
                'g:link' => url($product->url),
                'g:image_link' => $product->original_image,
                'g:price' => number_format($product->getCorrectPrice(), 0, '.', '') . ' RUB',
                'g:availability' => $product->nalich ? 'in stock' : 'out of stock',
                'g:mpn' => static::sanitize($product->kod),
                'g:condition' => 'new',
            ];

            fwrite($file, '<item>'.$this->getComposedTags().'</item>');
        }
    }

    protected function getProductTitle(Product $product)
    {
        $s = mb_strimwidth(static::sanitize($product->name), 0, 150);
        return mb_substr($s, 0, 1).mb_strtolower(mb_substr($s, 1));
    }

    protected function getProductDescription(Product $product)
    {
        $s = empty($product->text1) ? $product->text2 : $product->text1;
        return mb_strimwidth(static::sanitize($s), 0, 5000);
    }

    protected function getComposedTags()
    {
        $str = '';
        foreach ($this->tags as $name => $val) {
            $str .= "<$name>$val</$name>";
        }
        return $str;
    }

    protected static function sanitize($str)
    {
        return trim(htmlspecialchars(strip_tags($str)));
    }

    protected function getProducts()
    {
        $catalogs = Cattmr::join('catmaker', function ($join) {
            $join->on('cattmr.id_catmaker', '=', 'catmaker.id')
                ->where('catmaker.hide_in_YML', 0)
                ->where('catmaker.hide', 0);
        })
            ->addSelect('cattmr.id')
            ->where('cattmr.hide_in_YML', 0)
            ->where('cattmr.hide', 0)
            ->get();

        return Product::whereIn('id_cattmr', $catalogs->pluck('id'))
            ->published()
            ->where('goods.hide', 0)
            ->where('yml', 1)
            ->where('nalich', 1)
            ->where('price', '>', 0)
            ->where('importNew', 0)
            ->cursor();
    }
}
