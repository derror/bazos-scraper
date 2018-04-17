<?php

include('../src/Scraper.php');
include('../src/Model/AdCategory.php');

use BazosScraper\Scraper;

$scraper = new Scraper();
$scraper->setPortal(Scraper::PORTAL_BAZOS_SK);

$categories = $scraper->getCategories();

print_r($categories);