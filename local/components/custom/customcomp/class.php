<?

use Bitrix\Iblock\Iblock;
use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<?
    class SimpleComponent extends CBitrixComponent {


        public function onPrepareComponentParams($arParams)
        {
            $arParams["ID_IBLOCK_CATALOGS"] = trim($arParams["ID_IBLOCK_CATALOGS"]);
            $arParams["ID_IBLOCK_NEWS"] = trim($arParams["ID_IBLOCK_NEWS"]);

            $arParams["ID_IBLOCK_NEWS"] = intval($arParams["ID_IBLOCK_NEWS"]);
            $arParams["ID_IBLOCK_CATALOGS"] = intval($arParams["ID_IBLOCK_CATALOGS"]);

            return $arParams;
        }


        public function executeComponent()
        {   

            if($this->StartResultCache()) {
                global $APPLICATION;
                Loader::includeModule("iblock");

            $idBlockNews = $this->arParams["ID_IBLOCK_NEWS"];
            $idBlockCatalog = $this->arParams["ID_IBLOCK_CATALOGS"];
            $codeCustomChapter = $this->arParams["CODE_CUSTOM_CHAPTER"];

            $sections = $this->getSectionsOfIBlock($idBlockCatalog, $codeCustomChapter);
            $newsId = $this->getIdTiedNews($sections, $codeCustomChapter);
            $elementsOfSections = $this->getElementsOfSections($sections);
            $news = $this->getNews($newsId, $idBlockNews);
            $items = $this->getItems($elementsOfSections, $sections, $news, $codeCustomChapter);
            $this->arResult["ITEMS"] = $items;
            $countElements = $this->getCountElements($elementsOfSections);
            $APPLICATION->SetTitle("В каталоге товаров представлено товаров: $countElements");
            
            $this->includeComponentTemplate();
            }
            else {
                $this->abortResultCache();
            }
        }

        private function sectionToStringConversion($sections) {
            $strSections = '';
            
            for($i = 0; $i < count($sections); $i++) {
                $strSections .= $sections[$i]["NAME"];

                if( ($i + 1) !== count($sections)) {
                    $strSections .= ', ';
                }
            }

            return '(' . $strSections . ')'; 
        }

        private function getSectionsOfIBlock($idIBlock, $code) {
            $sectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($idIBlock);

            $sections = $sectionEntity::getList([
                "select" => ["ID", "NAME",  $code],
                "filter" => ["ACTIVE" => "Y", "!$code" => false]
            ])->fetchAll();

            return $sections;
        }

        private function getIdTiedNews($sections, $code) {
            $news = [];

            foreach($sections as $item) {
                foreach($item["$code"] as $link) {
                    $news[] = $link;
                }
            }

            $news = array_unique($news);

            return $news;
        }

        private function getElementsOfSections($sections) {

            $iBlockProducts = Iblock::wakeUp(2)->getEntityDataClass();

            $idSections = [];

            foreach($sections as $section) {
                $idSections[] = $section["ID"];
            }

            $products = $iBlockProducts::getList([
                "select" => ["ID","NAME","PRICE", "ARTNUMBER", "MATERIAL", "IBLOCK_SECTION_ID"],
                "filter" => ["IBLOCK_SECTION_ID" => $idSections]
            ])->fetchAll();

            return $products;
        }

        private function getNews($newsId, $idIBlockNews) {
            $iBlockNews = Iblock::wakeUp($idIBlockNews)->getEntityDataClass();

            $news = $iBlockNews::getList([
                "select" => ["NAME", "ID", "ACTIVE_FROM"],
                "filter" => ["ID" => $newsId]
            ])->fetchAll();

            return $news;
        }

        private function getItems($elementsOfSections, $sections, $news, $code) {
            $items = [];

            foreach($news as $newsItem) {   
                $item = [];
                $newsItem["ACTIVE_FROM"] = $newsItem["ACTIVE_FROM"]->format("Y.m.d");

                $item["NEWS"] = $newsItem;

                foreach($sections as $section) {
                    if(in_array($newsItem["ID"], $section["$code"])) {
                        $item["SECTIONS"][] = $section;
                        foreach($elementsOfSections as $element) {
                            if($element["IBLOCK_SECTION_ID"] === $section["ID"]) {
                                $element["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_PRODUCTS_S1_PRICE_VALUE"] = round($element["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_PRODUCTS_S1_PRICE_VALUE"]);
                                $item["ITEMS"][] = $element;
                            }
                        }
                    }
                }
                $item["SECTIONS"] = $this->sectionToStringConversion($item["SECTIONS"]);
                
                $items[] = $item;
            }

            return $items;

        }

        private function getCountElements($elementsOfSections) {
            return count($elementsOfSections);
        }

    }




?>