<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>


<?php

    $arComponentParameters = [
        "PARAMETERS" => [
            "ID_IBLOCK_CATALOG" => [
                "NAME" => "ID инфоблока с каталогом товаров",
                "PARENT" => "BASE",
                "TYPE" => "STRING"
            ],

            "ID_IBLOCK_CLASSIFIER" => [
                "NAME" => "ID инфоблока с классификатором",
                "PARENT" => "BASE",
                "TYPE" => "STRING"
            ],

            "TEMPLATE_URL_DETAIL" => [
                "NAME" => "Шаблон ссылки детального просмотра",
                "PARENT" => "BASE",
                "TYPE" => "STRING",
                "DEFAULT" => "#SITE_DIR#/products/#SECTION_ID#/#ID#/"
            ],

            "CACHE_TIME" => [
                "DEFAULT" => "36000000"
            ],

            "CODE_PROPERTY_CLASSIFIER" => [
                "NAME" => "Код свойства товара с привязкой к классификатору",
                "PARENT" => "BASE",
                "TYPE" => "STRING",
                "DEFAULT" => "FIRM"
            ]

        ]
    ];


?>