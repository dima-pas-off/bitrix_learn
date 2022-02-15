<?

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

            $groupsUsers = $this->getGroupsUsers();

            if($this->startResultCache(false, $groupsUsers)) {

                global $APPLICATION;

                Loader::includeModule("iblock");

                $idIBlockProducts = $this->arParams["ID_IBLOCK_CATALOG"];
                $idIBlockClassifiers = $this->arParams["ID_IBLOCK_CLASSIFIER"];
                $templateUrlDetail = $this->arParams["TEMPLATE_URL_DETAIL"];
                $codePropertyClassifier = $this->arParams["CODE_PROPERTY_CLASSIFIER"];

                $products = $this->getProductsWithClassifier($idIBlockProducts, $templateUrlDetail, $codePropertyClassifier);
                $classifiers = $this->getClassifiers($products, $idIBlockClassifiers, $codePropertyClassifier);
                $items = $this->getItems($products, $classifiers, $codePropertyClassifier);
        
                $this->arResult["ITEMS"] = $items;

                $APPLICATION->SetTitle("Разделов " . count($items));

                $this->includeComponentTemplate();
            }
            else {
                $this->abortResultCache();
            }
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

        private function getProductsWithClassifier($idIBlock, $templateUrlDetail, $code) {

            $products = [];
            

            $productsQuery = CIBlockElement::GetList(
                ["NAME" => "ASC", "SORT" => "ASC"],
                ["IBLOCK_ID" => $idIBlock, "ACTIVE" => "Y", "!PROPERTY_$code" => false, "CHECK_PERMISSIONS" => "Y"],
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