<?php

include('../src/Scraper.php');
include('../src/Model/AdCategory.php');
include('../src/Model/AdSubcategory.php');

use BazosScraper\Scraper;

$scraper = new Scraper();
$scraper->setPortal(Scraper::PORTAL_BAZOS_SK);

$categories = $scraper->getCategoriesTree();

print_r($categories);