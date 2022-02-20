<?

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(null, [
    "Custom\\NonExistentPageHandler" => "/local/php_interface/lib/classes/NonExistentPageHandler.php"
]);