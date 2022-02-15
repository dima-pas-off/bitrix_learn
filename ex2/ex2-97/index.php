<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


?><?$APPLICATION->IncludeComponent(
	"custom:simplecompex_97", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"ID_IBLOCK_NEWS" => "1",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"PROPERTY_CODE_AUTHOR" => "AUTHOR",
		"PROPERTY_CODE_TYPE_AUTHOR" => "UF_AUTHOR_TYPE"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>