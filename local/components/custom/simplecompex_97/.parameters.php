<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>



<?
    $arComponentParameters = [
        "PARAMETERS" => [

            "ID_IBLOCK_NEWS" => [
                "NAME" => "ID информационного блока с новостями",
                "PARENT" => "BASE",
                "TYPE" => "STRING"
            ],

            "PROPERTY_CODE_AUTHOR" => [
                "NAME" => "Код свойства информационного блока, в котором хранится Автор",
                "PARENT" => "BASE",
                "TYPE" => "STRING",
                "DEFAULT" => "AUTHOR"
            ],

            "PROPERTY_CODE_TYPE_AUTHOR" => [
                "NAME" => "Код пользовательского свойства пользователей, в котором хранится тип автора",
                "PARENT" => "BASE",
                "TYPE" => "STRING",
                "DEFAULT" => "UF_AUTHOR_TYPE"
            ],

            "CACHE_TIME" => [
                "DEFAULT" => "36000000"
            ]


        ]
    ]



?>