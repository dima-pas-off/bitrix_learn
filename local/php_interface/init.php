<? require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/classes/UpdateCacheHandler.php") ?>




<?php
    
    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", ["Custom\UpdateCacheHandler", "handler"]);

?>