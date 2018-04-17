<?php

namespace BazosScraper\Model;

/**
 * Class AdSubategory
 * @package BazosScraper\Model
 */
class AdSubcategory
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $url;

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
}