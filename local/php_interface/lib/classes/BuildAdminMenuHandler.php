<?
    namespace Custom;


    class BuildAdminMenuHandler {

        
        function handler(&$aGlobalMenu, &$aModuleMenu) {

            $isAdminCurrentUser = \Bitrix\Main\Engine\CurrentUser::get()->isAdmin();
            $idCurrentUser = \Bitrix\Main\Engine\CurrentUser::get()->getId();
            $groupsCurrentUser = \Bitrix\Main\UserTable::getUserGroupIds($idCurrentUser);
    
            $isCurrentUserContentEdiotr = in_array(5, $groupsCurrentUser); // 5 - id группы Контент-Редакторов
    
            if(!$isAdminCurrentUser && $isCurrentUserContentEdiotr) {
    
                foreach($aModuleMenu as  $key => $menu) { // убираются все меню, которые не относят к контентку в глобальном меню
                    if(! ($menu["parent_menu"] === "global_menu_content")) {
                        unset($aModuleMenu[$key]);
                    }
                }
        
                foreach($aGlobalMenu as $key => $menu) { //убираются все меню, которые не относят к контентку в модульном меню
                    if($key !== "global_menu_content") {
                        unset($aGlobalMenu[$key]);
                    }
                }
    
    
                foreach($aModuleMenu as $key => $menu) {
                    if(!preg_match("/iblock_admin.php[?]type=news/", $menu["url"])) {
                        unset($aModuleMenu[$key]);
                    }
                }
    
                $firstKeyModuleMenu = array_key_first($aModuleMenu);
    
                foreach($aModuleMenu[$firstKeyModuleMenu]["items"] as $key => $item) {
                    if(!preg_match("/iblock_element_admin.php[?]IBLOCK_ID=1&type=news/", $item["url"])) {
                        unset($aModuleMenu[$firstKeyModuleMenu]["items"][$key]);    
                    }
                }
    
    
            }
    
            
        }
    }



?>