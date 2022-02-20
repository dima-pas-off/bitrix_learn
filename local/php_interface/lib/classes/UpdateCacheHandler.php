<?
namespace Custom;



class UpdateCacheHandler {



    public function handler(&$arFields) {
        if($arFields["IBLOCK_ID"] == 3) {
            if (defined('BX_COMP_MANAGED_CACHE') && is_object($GLOBALS['CACHE_MANAGER'])) {	
	            $GLOBALS['CACHE_MANAGER']->ClearByTag('ex2_107');
            }
        }
    }
}ы



?>