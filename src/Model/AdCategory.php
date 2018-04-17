<?php

namespace BazosScraper\Model;

/**
 * Class AdCategory
 * @package BazosScraper\Model
 */
class AdCategory
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $url;

    /** @var int */
    protected $portal;

    /** @var array */
    protected $subcategories;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * @param int $portal
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;
    }

    /**
     * @return array
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * @param array $subcategories
     */
    public function setSubcategories($subcategories)
    {
        $this->subcategories = $subcategories;
    }

}