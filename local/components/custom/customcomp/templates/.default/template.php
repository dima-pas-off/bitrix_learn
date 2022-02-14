<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>


<div>
    <p><strong>Каталог</strong></p>
    <ul>
        <?foreach($arResult["ITEMS"] as $item): ?>
            <li><strong><?= $item["NEWS"]["NAME"] ?></strong> - 
                        <?= $item["NEWS"]["ACTIVE_FROM"] ?> 
                        <?=$item["SECTIONS"] ?>
                <ul>
                    <?foreach ($item["ITEMS"] as $element): ?>
                        <li>
                            <?=   $element["NAME"]
                                . ' - ' 
                                . $element["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_PRODUCTS_S1_PRICE_VALUE"] 
                                . ' - '
                                . $element["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_PRODUCTS_S1_MATERIAL_VALUE"]
                                . ' - '
                                . $element["IBLOCK_ELEMENTS_ELEMENT_FURNITURE_PRODUCTS_S1_ARTNUMBER_VALUE"]
                            
                            ?> 
                            
                        </li>
                    <? endforeach ?>    
                </ul>
            </li>
        <? endforeach ?>
    </ul>
</div>