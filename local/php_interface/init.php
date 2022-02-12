<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/classes/BuildingPageSeoHandler.php");


AddEventHandler("main", "OnBeforeProlog", ["Custom\BuildingPageSeoHandler", "handler"]);



?>