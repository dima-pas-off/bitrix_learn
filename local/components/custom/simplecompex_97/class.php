<?

use Bitrix\Iblock\Iblock;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\UserTable;

 if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>


<?
    class CustomSimpleComponent extends CBitrixComponent {


        function onPrepareComponentParams($arParams)
        {
            $arParams["ID_IBLOCK_NEWS"] = trim($arParams["ID_IBLOCK_NEWS"]);
            $arParams["ID_IBLOCK_NEWS"] = intval($arParams["ID_IBLOCK_NEWS"]);

            $arParams["PROPERTY_CODE_AUTHOR"] = trim($arParams["PROPERTY_CODE_AUTHOR"]);

            $arParams["PROPERTY_CODE_TYPE_AUTHOR"] = trim($arParams["PROPERTY_CODE_TYPE_AUTHOR"]);

            return $arParams;
        }


        function executeComponent()
        {   

            $currentUser = $this->getCurrentUser();

            if(!is_null($currentUser["ID"])) {
                global $APPLICATION;

                $users = $this->getUsers($currentUser);

                $idUsers = $this->getIdAllUsers($currentUser);
                
                $this->arResult["TITLE"] = '';
        
                if($this->startResultCache(false, $idUsers)) {

                    $news = $this->getNews($users, $currentUser);
                    $items = $this->getItems($users, $news);
                    $countNews = $this->getCountNews($news);

                    $this->arResult["ITEMS"] = $items;
                    $this->arResult["TITLE"] = "Выбранных новостей: $countNews";
                    $this->setResultCacheKeys(array("TITLE"));
                    
                    $this->includeComponentTemplate();
                }
                else {
                    $this->abortResultCache();
                }

                $APPLICATION->SetTitle($this->arResult["TITLE"]);
            }
        }


        private function getIdAllUsers($currentUser) {

            $idUsers = [];

            $users = UserTable::getList([
                "select" => ["ID"],
                "filter" => ["!ID" => $currentUser["ID"]]
            ]);

            while($res = $users->fetch()) {
                $idUsers[] = $res["ID"];
            }

            return $idUsers;
        }

        private function getIdUsers($users) {
            $idUsers = [];

            foreach($users as $user) {
                $idUsers[] = $user["ID"];
            }

            return $idUsers;
        }

        private function getCurrentUser() {
            $idCurrentUser = CurrentUser::get()->getId();
            $propertyCodeTypeAuthor = $this->arParams["PROPERTY_CODE_TYPE_AUTHOR"];        

            $currentUser = UserTable::getList([
                "select" => ["ID", "TYPE_AUTHOR" => $propertyCodeTypeAuthor],
                "filter" => ["ID" => $idCurrentUser]
            ]);

            return $currentUser->fetch();
        }

        private function getUsers($currentUser) {
            $propertyCodeTypeAuthor = $this->arParams["PROPERTY_CODE_TYPE_AUTHOR"];
            $idFieldAuthorGroupCurrentUser = intval($currentUser["TYPE_AUTHOR"]); 
            $idCurrentUser = $currentUser["ID"];

            $getUsersQuery = UserTable::getList([
                "select" => ["ID", "LOGIN"],
                "filter" => [$propertyCodeTypeAuthor => $idFieldAuthorGroupCurrentUser, "!ID" => $idCurrentUser]
            ]);

            $users = $getUsersQuery->fetchAll();

            return $users;
        }

        private function getNews($users, $currentUser) {
            
            $idIBlockNews = $this->arParams["ID_IBLOCK_NEWS"];
            $propertyNewsAuthor = $this->arParams["PROPERTY_CODE_AUTHOR"];

            $iBlockNewsEntity = Iblock::wakeUp($idIBlockNews)->getEntityDataClass();

            $idUsers = $this->getIdUsers($users);

            $news = [];

            $idNewsCurrentUser = [];
            $newsCurrentUser = $iBlockNewsEntity::getList([
                "select" => ["ID", $propertyNewsAuthor],
                "filter" => ["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_NEWS_" . $propertyNewsAuthor ."_VALUE" => $currentUser["ID"]]
            ]);

            while($res = $newsCurrentUser->fetch()) {
                $idNewsCurrentUser[] = intval($res["ID"]);
            }

            $newsQuery = $iBlockNewsEntity::getList([
                "select" => ["ID", "NAME", $propertyNewsAuthor],
                "filter" => [
                    "IBLOCK_ELEMENTS_ELEMENT_FURNITURE_NEWS_" . $propertyNewsAuthor ."_VALUE" => $idUsers
                    ]
            ]);

            while($res = $newsQuery->fetch()) {
                if(!in_array($res["ID"], $idNewsCurrentUser)) {
                    $news[] = $res;
                }
            }

            return $news;
        }

        private function getItems($users, $news) {
            $items = [];
            $propertyNewsAuthor = $this->arParams["PROPERTY_CODE_AUTHOR"];

            foreach($users as $user) {
                $item = [];
                $item["USER"] = $user;
                
                foreach($news as $itemNews) {
                    if($itemNews["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_NEWS_" . $propertyNewsAuthor ."_VALUE"] === $user["ID"]) {
                        $item["ITEMS"][] = $itemNews;
                    }
                }

                $items[] = $item;
            }

            return $items;
        }

        private function getCountNews($news) {
            $idNews = [];

            foreach($news as $newsItem) {
                $idNews[] = $newsItem["ID"];
            }

            return count(array_unique($idNews));
        }

        
    }




?>