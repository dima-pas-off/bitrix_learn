<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ex2_71");
?><?$APPLICATION->IncludeComponent(
	"custom:simplecomp.exam.ex_71",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_PROPERTY_CLASSIFIER" => "FIRM",
		"ID_IBLOCK_CATALOG" => "2",
		"ID_IBLOCK_CLASSIFIER" => "7",
		"TEMPLATE_URL_DETAIL" => "#SITE_DIR#/products/#SECTION_ID#/#ID#/"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>