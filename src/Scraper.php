<?php

namespace BazosScraper;

use BazosScraper\Model\AdCategory;
use BazosScraper\Model\AdSubcategory;

/**
 * Class Scraper
 * @package BazosScraper
 */
class Scraper
{
    const PORTAL_BAZOS_SK = 1;
    const PORTAL_BAZOS_CZ = 2;
    const PORTAL_BAZOS_AT = 3;

    private $portalUrls = [
        self::PORTAL_BAZOS_SK => 'https://www.bazos.sk',
        self::PORTAL_BAZOS_CZ => 'https://www.bazos.cz',
        self::PORTAL_BAZOS_AT => 'https://www.bazos.at',
    ];

    protected $portal;

    /**
     * Scraper constructor.
     * @param int $portal
     */
    public function __construct($portal = null)
    {
        $this->setPortal($portal);
    }

    /**
     * @param int $portal
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;
    }

    /**
     * @return int
     */
    protected function getPortal()
    {
        return $this->portal;
    }

    /**
     * @return string
     */
    protected function getPortalUrl()
    {
        return $this->portalUrls[$this->getPortal()];
    }

    /**
     * Will return general categories
     *
     * @return AdCategory[]
     * @throws \Exception
     */
    public function getCategories()
    {
        $categories = [];

        // category wrapper class name
        $categoryWrapperClassName = "icontblcell1";

        // load HTML of the page
        $mainPage = $this->fetchData($this->getPortalUrl());

        $dom = new \DOMDocument;
        $dom->loadHTML($mainPage);

        $divs = $dom->getElementsByTagName('div');

        foreach ($divs as $element) {
            if ($element->getAttribute('class') == $categoryWrapperClassName) {
                $category = $element->getElementsByTagName('a');

                foreach ($category as $item) {
                    // skip subcategories
                    if (empty($item->childNodes[0]) || $item->childNodes[0]->nodeName !== 'img') {
                        continue;
                    }
                    $category = new AdCategory();
                    $category->setName($item->textContent);
                    $category->setUrl($item->getAttribute('href'));
                    $category->setPortal($this->getPortal());
                    $categories[] = $category;
                }
            }
        }

        return $categories;
    }

    /**
     * Will return all categories with subcategories
     *
     * @return AdCategory[]
     * @throws \Exception
     */
    public function getCategoriesTree()
    {
        // load categories
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            $category->setSubcategories($this->getSubcategories($category));
        }
        return $categories;
    }

    /**
     * Will return all subcategories for given category
     *
     * @param AdCategory $category
     * @return array
     * @throws \Exception
     */
    protected function getSubcategories(AdCategory $category)
    {
        // disable libxml errors due to some HTML syntax errors
        libxml_use_internal_errors(true);

        // subcategory wrapper class name
        $subcategoryWrapperClassName = "barvaleva";

        // load HTML of the page
        $categoryPage  = $this->fetchData($category->getUrl());
        $subcategories = [];
        $dom           = new \DOMDocument();
        $dom->loadHTML($categoryPage);
        $divs = $dom->getElementsByTagName('div');

        foreach ($divs as $div) {
            if ($div->getAttribute('class') == $subcategoryWrapperClassName) {
                foreach ($div->childNodes as $item) {
                    // skip empty elements
                    if ($item->localName !== 'a') {
                        continue;
                    }
                    $subcategory = new AdSubcategory();
                    $subcategory->setName($item->textContent);
                    $subcategory->setUrl(
                        $this->composeFullCategoryUrl($item->getAttribute('href'), $category->getUrl())
                    );
                    $subcategories[] = $subcategory;
                }
            }
        }
        return $subcategories;
    }

    /**
     * @param int $limit
     * @param bool $downloadDetails
     */
    public function getAds($limit = 1, $downloadDetails = false)
    {
        // @TODO
    }


    /**
     * @param string $url
     * @return mixed
     * @throws \Exception
     */
    private function fetchData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);
        return $response;
    }

    /**
     * Transform relative URI to the full subcategory URL
     *
     * @param $subcategoryUrl
     * @param $categoryAbsoluteUrl
     * @return string
     */
    private function composeFullCategoryUrl($subcategoryUrl, $categoryAbsoluteUrl)
    {
        if (!parse_url($subcategoryUrl, PHP_URL_SCHEME)) {
            $subcategoryUrl = implode('/', [
                trim($categoryAbsoluteUrl, '/'),
                trim($subcategoryUrl, '/')
            ]);
        }
        return $subcategoryUrl;
    }

}