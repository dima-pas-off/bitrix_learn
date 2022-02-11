<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<?

use Bitrix\Iblock\Iblock;
use Bitrix\Main\Loader;

    $arParams["ID_BLOCK_CANONICAL"] = intval($arParams["ID_BLOCK_CANONICAL"]);

    if($arParams["ID_BLOCK_CANONICAL"] !== 5) die();


    if(Loader::includeModule("iblock")) {

        $iBlock = Iblock::wakeUp(5)->getEntityDataClass();

        $element = $iBlock::getList([
            "select" => ["ID", "NAME", "BINDING"],
            "filter" => [
            "IBLOCK_ELEMENTS_ELEMENT_CANONICAL_BINDING_IBLOCK_GENERIC_VALUE" => intval($arResult["ID"])] 
            //поиск элемента типа Canonical, где ID привязанной новости равно ID детальной новости
        ])->fetchObject();

        
        if(!is_null($element)) {
            $nameCanonicalElement = $element->getName();
            $APPLICATION->SetPageProperty("canonical", $nameCanonicalElement);
        }
 
    }
 

?>