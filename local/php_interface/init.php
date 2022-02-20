<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/autoload.php"); 



    AddEventHandler("main", "OnEpilog", ["Custom\\NonExistentPageHandler", "handler"]);

