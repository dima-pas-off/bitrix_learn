<?

use Bitrix\Main\Context;
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>



<?
    class CustomSimpleComponent extends CBitrixComponent {

        public function onPrepareComponentParams($arParams)
        {
            $arParams["ID_IBLOCK_CATALOG"] = trim($arParams["ID_IBLOCK_CATALOG"]);
            $arParams["ID_IBLOCK_CATALOG"] = intval($arParams["ID_IBLOCK_CATALOG"]);

            $arParams["ID_IBLOCK_CLASSIFIER"] = trim($arParams["ID_IBLOCK_CLASSIFIER"]);
            $arParams["ID_IBLOCK_CLASSIFIER"] = intval($arParams["ID_IBLOCK_CLASSIFIER"]);


            if(strlen($arParams["TEMPLATE_URL_DETAIL"]) === 0) {
                $arParams["TEMPLATE_URL_DETAIL"] = "#SITE_DIR#/products/#SECTION_ID#/#ID#/";
            }

            $arParams["TEMPLATE_URL_DETAIL"] = trim($arParams["TEMPLATE_URL_DETAIL"]);

            $arParams["CODE_PROPERTY_CLASSIFIER"] = trim($arParams["CODE_PROPERTY_CLASSIFIER"]);

            return $arParams;
        }


        public function executeComponent()
        {   
            global $APPLICATION;
            $groupsUsers = $this->getGroupsUsers();
            $request = Context::getCurrent()->getRequest();
            $param = $request->getQuery("F");
            $this->arResult["TITLE"] = '';
            $additionalCacheId = array_merge($groupsUsers);

            if(!is_null($param)) {
               $additionalCacheId[] = "Y";
            }
            else {
                $additionalCacheId[] = "N";
            }

            if($this->startResultCache(false, $additionalCacheId)) {

                if(!is_null($param)) {
                    $this->abortResultCache();
                }

                Loader::includeModule("iblock");

                $idIBlockProducts = $this->arParams["ID_IBLOCK_CATALOG"];
                $idIBlockClassifiers = $this->arParams["ID_IBLOCK_CLASSIFIER"];
                $templateUrlDetail = $this->arParams["TEMPLATE_URL_DETAIL"];
                $codePropertyClassifier = $this->arParams["CODE_PROPERTY_CLASSIFIER"];

                $products = $this->getProductsWithClassifier($idIBlockProducts, $templateUrlDetail, $codePropertyClassifier, $param);
                $classifiers = $this->getClassifiers($products, $idIBlockClassifiers, $codePropertyClassifier);
                $items = $this->getItems($products, $classifiers, $codePropertyClassifier);
        
                $this->arResult["ITEMS"] = $items;
                $this->arResult["TITLE"] = "Разделов " . count($items);
                $this->setResultCacheKeys(["TITLE"]);

                $this->includeComponentTemplate();
            }
            else {
                $this->abortResultCache();
            }

            $APPLICATION->SetTitle($this->arResult["TITLE"]);
        }


        private function getGroupsUsers() {
            $idGroups = [];

            $result = \Bitrix\Main\GroupTable::getList(array(
                'select'  => array('ID'), 
                'filter'  => array() 
            ));
                
            while ($arGroup = $result->fetch()) {
                $idGroups[] = $arGroup["ID"];
            }

            return $idGroups;
        }

        private function getProductsWithClassifier($idIBlock, $templateUrlDetail, $code, $param) {

            $products = [];
            
            $arFilter = [
            "IBLOCK_ID" => $idIBlock, 
            "ACTIVE" => "Y", 
            "!PROPERTY_$code" => false, 
            "CHECK_PERMISSIONS" => "Y"
            ];


            if(!is_null($param)) {
                $arAdditionalFilter = [

                    ["LOGIC" => "OR",
                    ["<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "Дерево, ткань"],
                    ["<PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "Металл, пластик"]
                ]];

                $arFilter = array_merge($arFilter, $arAdditionalFilter);
            }

            $productsQuery = CIBlockElement::GetList(
                ["NAME" => "ASC", "SORT" => "ASC"],
                $arFilter,
                false,
                false,
                ["ID", "NAME", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL", "PROPERTY_$code", "DETAIL_PAGE_URL"]
            );

            $productsQuery->SetUrlTemplates($templateUrlDetail);
            
            while($product = $productsQuery->GetNext()) {
                $products[] = $product;
            }  
        
            return $products;
        }

        private function getClassifiers($products, $idIBlockClassifiers, $code) {
            
            $classifiers = [];
            $idClassifiers = [];
            $codePropertyClassifierValue = "PROPERTY_" . $code . "_VALUE";

            foreach($products as $product) {
                if(!in_array($product[$codePropertyClassifierValue], $idClassifiers)) {
                    $idClassifiers[] = $product[$codePropertyClassifierValue];
                }
            }


            $classifiersQuery = CIBlockElement::GetList(
                [],
                ["IBLOCK_ID" => $idIBlockClassifiers, "ID" => $idClassifiers, "CHECK_PERMISSIONS" => "Y" ],
                false,
                false,
                ["ID", "NAME"]
            );

            while($classifier = $classifiersQuery->Fetch()) {
                $classifiers[] = $classifier;
            }


            return $classifiers;
        }

        private function getItems($products, $classifiers, $code) {
            $items = [];
            $codePropertyClassifierValue = "PROPERTY_" . $code . "_VALUE";

            foreach($classifiers as $classifier) {
                $item["CLASSIFIER"] = $classifier;
                $item["PRODUCTS"] = [];
                foreach($products as $product) {
                    if($product["PROPERTY_FIRM_VALUE"] === $classifier['ID']) {
                        $item["PRODUCTS"][] = $product;
                    }
                }

                $items[] = $item;
            }

            return $items;
        }

    }


?>