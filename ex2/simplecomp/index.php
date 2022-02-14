<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("simplecomp");
?><br>
 <?$APPLICATION->IncludeComponent(
	"custom:customcomp",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_CUSTOM_CHAPTER" => "UF_NEWS_LINK",
		"ID_IBLOCK_CATALOGS" => "2",
		"ID_IBLOCK_NEWS" => "1"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>