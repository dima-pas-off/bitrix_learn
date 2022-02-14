<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("simplecomp");
?><?$APPLICATION->IncludeComponent(
	"custom:customcomp", 
	".default", 
	array(
		"CODE_CUSTOM_CHAPTER" => "UF_NEWS_LINK",
		"ID_BLOCK_NEWS" => "1",
		"ID_IBLOCK_CATALOGS" => "2",
		"ID_IBLOCK_NEWS" => "1",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000"
	),
	false
);?><br>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>