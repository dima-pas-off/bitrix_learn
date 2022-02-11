<?


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
    if($arParams["SPECIAL_DATE"] === 'Y') {
        $activeFromLastNews = $arResult["ITEMS"][0]["ACTIVE_FROM"];
        $APPLICATION->SetPageProperty("specialdate", $activeFromLastNews);
    }
?>