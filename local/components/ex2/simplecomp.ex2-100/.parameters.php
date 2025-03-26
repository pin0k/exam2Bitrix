<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => [
		"NEWS_IBLOCK_ID" => [
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		],
		"CODE_PROPERTY_AUTHOR" => [
			"NAME" => GetMessage("CODE_PROPERTY_AUTHOR"),
			"TYPE" => "STRING",
		],
		"CODE_PROPERTY_AUTHOR_TYPE" => [
			"NAME" => GetMessage("CODE_PROPERTY_AUTHOR_TYPE"),
			"TYPE" => "STRING",
		],
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
	],
);