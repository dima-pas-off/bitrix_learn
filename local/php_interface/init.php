<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/lib/classes/SendFeedbackFormHandler.php");



AddEventHandler("main", "OnBeforeEventAdd", ["Custom\SendFeedbackFormHandler", "handler"]);






?>