<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<ul>
    <?foreach($arResult["SUMMARY"] as $key => $arItem):?>
        <li>
            [<?=$key;?>] - <?=$arItem["LOGIN"]?>
            <ul>
                <?foreach($arItem["NEWS"] as $new):?>
                    <li> - <?=$new["NAME"]?></li>
                <?endforeach;?>
            </ul>
        </li>
    <?endforeach;?>
</ul>
