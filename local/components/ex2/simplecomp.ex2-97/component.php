<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}
global $USER;

if ($USER->isAuthorized() && $this->StartResultCache(false, $USER->GetID())) {
	$arButtons = CIBlock::GetPanelButtons($arParams["PRODUCTS_IBLOCK_ID"]);
	$this->AddIncludeAreaIcon(
		[
			'URL'   => $buttons['submenu']['element_list']['ACTION_URL'],
			'TITLE' => GetMessage('SIMPLECOMP_EXAM2_PARAMS_MENU_IBLOCK_BUTTON'),
			'IN_PARAMS_MENU' => 'Y'
		]
	);

	if(intval($arParams["NEWS_IBLOCK_ID"]) > 0 && !empty($arParams["PROPERTY_AUTHOR"]) && !empty($arParams["PROPERTY_AUTHOR_TYPE"])) {
		// список пользователей
		$users = [];
		$usersORM = CUser::GetList(
			"",
			"",
			[
				"!".$arParams["PROPERTY_AUTHOR_TYPE"] => false,
			],
			[
				"SELECT" => [$arParams["PROPERTY_AUTHOR_TYPE"]],
				"FIELDS" => ["ID", "LOGIN"]
			]
		);
		while($arElement = $usersORM->Fetch()) {
			$users[] = $arElement;
		}

		// Список новостей
		$newsORM = CIBlockElement::GetList(
			[
				"NAME" => "ASC"
			], 
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			], 
			false, 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				"PROPERTY_AUTHOR",
			]
		);
		$news = [];
		$arResult["SUMMARY"] = [];
		$arResult["COUNT_NEWS"] = 0;
		while($arElement = $newsORM->Fetch()) {	
			if(intval($USER->GetID()) !== $arElement["PROPERTY_AUTHOR_VALUE"] && !empty($arElement["PROPERTY_AUTHOR_VALUE"])) {
				$news[] = $arElement["ID"];
				foreach($users as $user) {
					if($user["ID"] == $arElement["PROPERTY_AUTHOR_VALUE"]) {
						$arResult["SUMMARY"][intval($user["ID"])]["ID"] = $user["ID"];
						$arResult["SUMMARY"][intval($user["ID"])]["LOGIN"] = $user["LOGIN"];
						$arResult["SUMMARY"][intval($user["ID"])]["NEWS"][] = [
							"NAME" => $arElement["NAME"]
						];
					}
				};
			}
		}

		$arResult["COUNT_NEWS"] = count(array_unique($news));
		$this->SetResultCacheKeys(["SUMMARY", "COUNT_NEWS"]);
	} else {
		$this->AbortResultCache();
	}
}
$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_TITLE', ['#NEWS_COUNT#' => $arResult["COUNT_NEWS"]]));