<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<? $arComponentParameters = [

    "PARAMETERS" => [
        "ID_IBLOCK_CATALOGS" => [
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с каталогом товаров",
            "TYPE" => "STRING"
        ],
        "ID_IBLOCK_NEWS" => [
            "PARENT" => "BASE",
            "NAME" => "ID инфоблока с новостями",
            "TYPE" => "STRING"
        ],
        "CODE_CUSTOM_CHAPTER" => [
            "PARENT" => "BASE",
            "NAME" => "Код пользовательского свойства разделов каталога, в котором хранится привязка к новостям",
            "TYPE" => "STRING",
            "DEFAULT" => "UF_NEWS_LINK"
        ],

        "CACHE_TIME" => [
            "DEFAULT" => "36000000"
        ]
        ]
];
