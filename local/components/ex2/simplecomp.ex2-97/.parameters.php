<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
			"PARENT" => "BASE",
		),
		"PROPERTY_AUTHOR" => array(
			"NAME" => GetMessage("PROPERTY_AUTHOR"),
			"TYPE" => "STRING",
			"PARENT" => "BASE",
		),
		"PROPERTY_AUTHOR_TYPE" => array(
			"NAME" => GetMessage("PROPERTY_AUTHOR_TYPE"),
			"TYPE" => "STRING",
			"PARENT" => "BASE",
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
	),
);