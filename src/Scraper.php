<?php

namespace BazosScraper;

/**
 * Class Scraper
 * @package BazosScraper
 */
class Scraper
{
    const PORTAL_URL_SK = 'https://www.bazos.sk';
    const PORTAL_URL_CZ = 'https://www.bazos.cz';
    const PORTAL_URL_AT = 'https://www.bazos.at';

    protected $portalUrl;

    /**
     * Scraper constructor.
     * @param null $portalUrl
     */
    public function __construct($portalUrl = null)
    {
        $this->setPortalUrl($portalUrl);
    }

    public function setPortalUrl($portalUrl)
    {
        $this->portalUrl = $portalUrl;
    }

    public function getCategories()
    {
        // @TODO
    }

    public function getCategoriesTree()
    {
        // @TODO
    }

    protected function getSubcategories(Model\AdCategory $category)
    {
        // @TODO
    }

    /**
     * @param int $limit
     * @param bool $downloadDetails
     */
    public function getAds($limit = 1, $downloadDetails = false)
    {
        // @TODO
    }

}