<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


$minPrice = $arResult["MIN_PRICE"];
$maxPrice = $arResult["MAX_PRICE"];

$bufer = "<div style='color:red; margin: 34px 15px 35px 15px'>
    <p>MIN: $minPrice </p>
    <p>MAX: $maxPrice </p>
</div>";

$APPLICATION->AddViewContent("price", $bufer);