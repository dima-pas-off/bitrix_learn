<?

use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\UserGroupTable;
use Bitrix\Main\UserTable;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2");
?>



<?

var_dump(preg_match("iblock_element_admin.php?IBLOCK_ID=5&type=news", "iblock_admin.php?type=news&amp;lang=ru&amp;admin=N"));



?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>