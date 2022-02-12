<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/classes/BuildAdminMenuHandler.php");

AddEventHandler("main", "OnBuildGlobalMenu", ["Custom\BuildAdminMenuHandler", "handler"]);


?>