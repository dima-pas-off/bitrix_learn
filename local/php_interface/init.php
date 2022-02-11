<?
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/classes/NonExistentPageHandler.php");


    AddEventHandler("main", "OnEpilog", ["Custom\\NonExistentPageHandler", "handler"]);


?>