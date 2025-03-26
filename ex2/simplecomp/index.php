<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.ex2-100",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CODE_PROPERTY_AUTHOR" => "AUTHOR",
		"CODE_PROPERTY_AUTHOR_TYPE" => "UF_AUTHOR_TYPE",
		"NEWS_IBLOCK_ID" => "1"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>