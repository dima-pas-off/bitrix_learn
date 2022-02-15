<?

use Bitrix\Main\Diag\Debug;

 if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<p><strong>Авторы и Новости</strong></p>

<ul>
    <? foreach($arResult["ITEMS"] as $item): ?>
        <li>
            <?= "[" . $item["USER"]["ID"] . ']'  . ' - ' . $item["USER"]["LOGIN"]?>
            <ul>
                <? foreach($item["ITEMS"] as $news): ?>
                    <li><?= '- ' . $news["NAME"] ?></li>
                <? endforeach ?>    
            </ul>
        </li>
    <? endforeach ?>    
</ul>