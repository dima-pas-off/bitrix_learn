<?
namespace Custom;

use Bitrix\Main\Application;

class BuildingPageSeoHandler {


    function handler() {
        global $APPLICATION;


        $urlCurrentPage = \Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage();

        if(\Bitrix\Main\Loader::includeModule("iblock")) {

            $iBlock = \Bitrix\Iblock\Iblock::wakeUp(6)->getEntityDataClass();

            $elementsIBlock = $iBlock::getList([
                "select" => ["NAME", "DESCRIPTION", "TITLE"],
                "filter" => ["ACTIVE" => "Y"]
            ]);

            while($element = $elementsIBlock->fetch()) {

                $elementUrl = $element["NAME"] . "index.php";
                $elementPropertyTitle = $element["IBLOCK_ELEMENTS_ELEMENT_METATAGS_TITLE_VALUE"];
                $elementPropertyDescription = $element["IBLOCK_ELEMENTS_ELEMENT_METATAGS_DESCRIPTION_VALUE"];

                if($elementUrl === $urlCurrentPage) {
                    $APPLICATION->SetPageProperty("title", $elementPropertyTitle);
                    $APPLICATION->SetPageProperty("description", $elementPropertyDescription);
                    break;
                }
            }


        }
         
    }
}


?>