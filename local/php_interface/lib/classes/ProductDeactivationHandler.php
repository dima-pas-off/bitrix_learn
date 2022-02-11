<?php
namespace Custom;


    class ProductDeactivationHandler {



        function handler(&$arFields) {
            global $APPLICATION;

        if($arFields["IBLOCK_ID"] === 2 && $arFields["ACTIVE"] === "N") {
            
            if(!\Bitrix\Main\Loader::includeModule("iblock")) return;

            $iBlock = \Bitrix\Iblock\Iblock::wakeUp(2)->getEntityDataClass();

            $element = $iBlock::getList([
                "select" => ["SHOW_COUNTER"],
                "filter" => ["ID" => $arFields["ID"]]
            ])->fetchAll();

            $showCounterElement = $element[0]["SHOW_COUNTER"];

            if(is_null($showCounterElement)) $showCounterElement = 0;

            if($showCounterElement < 2 || is_null($showCounterElement)) {
                $APPLICATION->throwException("Товар невозможно деактивировать, у него  $showCounterElement просмотров»");
                return false;
            }
        }
        }
    }


?>