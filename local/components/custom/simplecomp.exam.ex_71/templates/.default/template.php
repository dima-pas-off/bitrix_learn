<?

use Bitrix\Main\Diag\Debug;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>


<div>
    <p><strong>Каталог:</strong></p>

    <ul>
        <? foreach($arResult["ITEMS"] as $item): ?>
            <li>
                <strong><?= $item["CLASSIFIER"]["NAME"] ?></strong>

                <ul>
                    <?foreach($item["PRODUCTS"] as $product): ?>
                        <li>
                            <?= $product["NAME"] 
                                . ' - '
                                . $product["PROPERTY_ARTNUMBER_VALUE"] 
                                . ' - '
                                . $product["PROPERTY_MATERIAL_VALUE"]
                                . ' - ' ?>
                               <?= "(" . $product["DETAIL_PAGE_URL"] . ")"?>
                                
                        </li>
                    <? endforeach ?>    
                </ul>
            </li>
        <? endforeach ?>    
    </ul>
</div>