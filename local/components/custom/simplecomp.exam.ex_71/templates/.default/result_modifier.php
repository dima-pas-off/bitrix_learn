<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


$arPrice = [];

foreach($arResult["PRODUCTS"] as $product) {
    $arPrice[] = intval($product["PROPERTY_PRICE_VALUE"]);
}

$minPrice = min($arPrice);
$maxPrice = max($arPrice);


$arResult["MAX_PRICE"] = $maxPrice;
$arResult["MIN_PRICE"] = $minPrice;

$this->__component->setResultCacheKeys(["MAX_PRICE", "MIN_PRICE"]);

