<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arParams["ID_IBLOCK_CANONICAL"])) {
    $canonicalORM = CIBlockElement::GetList(
        [], 
        [
            "IBLOCK_ID" => $arParams["ID_IBLOCK_CANONICAL"], 
            "PROPERTY_NEW"=> $arResult["ID"]
        ]
    );
    if($canonicalLink = $canonicalORM->Fetch()) {
       $arResult["CANONICAL_LINK"] = $canonicalLink["NAME"];
        $this->getComponent()->SetResultCacheKeys(['CANONICAL_LINK']);
    };
}
?>