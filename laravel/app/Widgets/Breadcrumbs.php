<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Breadcrumbs extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'links' => [],
        'type' => '',
        'element' => '',
        'element2' => '',
        'element3' => '',
        'element4' => ''
    ];


    protected $homepage = false;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        
        $element = $this->config['element'];
        $element2 = $this->config['element2'];
        $element3 = $this->config['element3'];
        $element4 = $this->config['element4'];

        switch ($this->config['type']) {

            case "vendor":

                $this->pushLinks('Производители', '/brands');
                $this->pushLinks($element->name);

                $this->homepage = true;

                break;

            case "wishlist":
                $this->pushLinks('Закладки');
                $this->homepage = true;
                break;
            case "sitemap":
                $this->pushLinks('Карта сайта');
                $this->homepage = true;
                break;
            case "cart":
                $this->pushLinks('Корзина');
                $this->homepage = true;
                break;
            case "news":
                $this->pushLinks('Новости');
                $this->homepage = true;
                break;
            case "profile":
                $this->pushLinks('Личный кабинет', '/profile');
                $this->pushLinks($element);
                break;
            case "order":
                $this->pushLinks('Оформление заказа');
                $this->homepage = true;
                break;
            case "feedback":
                $this->pushLinks('Обратная связь');
                $this->homepage = true;
                break;
            case "sales":
                $this->pushLinks('Распродажа');
                $this->homepage = true;
                break;
            case "page":
                $this->pushLinks($element->name);
                $this->homepage = true;
                break;
            case "category":
                $this->pushLinks($element->name);
                break;
            case "sub_category":
                $this->pushLinks($element->category->name, $element->category->url);
                $this->pushLinks($element->name);
                break;
            case "sub_category2":
                $this->pushLinks($element->name, $element->url);
                $this->pushLinks($element2->name, $element->getUrlWithSubCategory($element2));
                $this->pushLinks($element3->name);
                break;
            case "sub_category2_vendor":
                $this->pushLinks($element->name, $element->url);
                $this->pushLinks($element2->name, $element->getUrlWithVendor($element2));
                $this->pushLinks($element3->name, $element->getUrlWithSubCategory($element3));
                $this->pushLinks($element4->name);
                break;
            case "sub_category_vendor":
                $this->pushLinks($element->category->name, $element->category->url);
                $this->pushLinks($element2->name, $element->category->getUrlWithVendor($element2));
                $this->pushLinks($element->name);
                break;
            case "product":
                if($element->category)
                    $this->pushLinks($element->category->name, $element->category->url);
                if($element->vendor)
                    $this->pushLinks($element->vendor->name, $element->category->getUrlWithVendor($element->vendor));
                if($element->sub_category)
                    $this->pushLinks($element->sub_category->name, $element->category->getUrlWithVendorAndSubcategory($element->vendor, $element->sub_category));
                if($element->sub_category2)
                    $this->pushLinks($element->sub_category2->name, $element->category->getUrlSubcategory2($element->sub_category, $element->sub_category2, $element->vendor));
                $this->pushLinks($element->name);
                break;
                            
                

        }

        if ($this->homepage)
            $this->addHomepage();

        return view('widgets.breadcrumbs', [
            'config' => $this->config,
        ]);
    }

    public function addHomepage()
    {
        array_unshift($this->config['links'], array(
            'title' => 'Главная',
            'url' => '/'
        ));
    }


    public function pushLinks($title, $url = ''){

        array_push($this->config['links'], array(
            'title' => $title,
            'url' => $url
        ));

    }



}
