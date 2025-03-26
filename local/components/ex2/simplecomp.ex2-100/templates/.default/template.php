<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if(count($arResult["AUTHORS"]) > 0) :?>
    <ul>
    <?foreach($arResult["AUTHORS"] as $key => $arItem):?>
    <li>        
        <p>[<?=$key;?>] - <?=$arItem['LOGIN'];?></p>
        <ul>
            <?foreach($arItem["NEWS"] as $newsItem): ?>
                <li>
                    - <?=$newsItem["NAME"];?>
                </li>
            <?endforeach;?>
        </ul>
    </li>
    <?endforeach;?>
</ul>
<?endif;?>