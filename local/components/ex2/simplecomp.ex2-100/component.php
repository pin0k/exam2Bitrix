<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

global $USER;

if($USER -> IsAuthorized() && intval($arParams["NEWS_IBLOCK_ID"]) > 0) {
	$arButtons = CIBlock::GetPanelButtons($arParams["NEWS_IBLOCK_ID"]);
	$this->AddIncludeAreaIcon(
		[
			'URL' => $arButtons["submenu"]["element_list"]["ACTION_URL"],
			'TITLE' => GetMessage('IB_IN_ADMIN'),
			'IN_PARAMS_MENU' => 'Y'
		]
	);
}

if ($USER->IsAuthorized() && $this->StartResultCache(false, $USER->GetID())) {
	if(intval($arParams["NEWS_IBLOCK_ID"]) > 0 && !empty($arParams["CODE_PROPERTY_AUTHOR"]) && !empty($arParams["CODE_PROPERTY_AUTHOR_TYPE"])) {
		$arResult["COUNT_NEWS"] = 0;
		$currentUserId = $USER->GetID();
		$currentUserType = CUser::GetList(
			($by = 'ID'),
			($order = 'asc'),
			['ID' => $currentUserId],
			['SELECT' => [$arParams["CODE_PROPERTY_AUTHOR_TYPE"]]]
		)->Fetch()[$arParams["CODE_PROPERTY_AUTHOR_TYPE"]];
		 

		$usersORM = CUser::GetList(
			($by = 'ID'),
			($order = 'asc'),
			[
				$arParams["CODE_PROPERTY_AUTHOR_TYPE"] => $currentUserType,
				//'!ID' => $currentUserId
			],
			['SELECT' => ["LOGIN", "ID"]]
		);
		$usersList = [];
		while($arUser = $usersORM->Fetch()) {
			$usersList[$arUser['ID']] = ["LOGIN" => $arUser["LOGIN"]];
			$usersListId[] = $arUser['ID']; 
		}
		
		$arNewsAuthor = [];
		$arNewsList = [];
		$newsORM = CIBlockElement::GetList(
			[], 
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"PROPERTY_".$arParams["CODE_PROPERTY_AUTHOR"] => $usersListId,
			], 
			false, 
			false, 
			[
				"NAME",
				"ACTIVE_FROM",
				"ID",
				"IBLOCK_ID",
				"PROPERTY_".$arParams["CODE_PROPERTY_AUTHOR"]
			]
		);

		$arNewsId = [];
		while($arNews = $newsORM->GetNext()) {
			$arNewsAuthor[$arNews["ID"]][] = $arNews["PROPERTY_".$arParams["CODE_PROPERTY_AUTHOR"]."_VALUE"];

			if(empty($arNewsList[$arNews["ID"]])) {
				$arNewsList[$arNews["ID"]] = $arNews;
			}

			if($arNews["PROPERTY_".$arParams["CODE_PROPERTY_AUTHOR"]."_VALUE"] != $currentUserId) {
				$arNewsList[$arNews['ID']]['AUTHORS'][] = $arNews["PROPERTY_".$arParams["CODE_PROPERTY_AUTHOR"]."_VALUE"];
			}
		}

		foreach($arNewsList as $key => $value) {
			if(in_array($currentUserId, $arNewsAuthor[$value['ID']])) 
				continue;
			foreach($value['AUTHORS'] as $authorID) {
				$usersList[$authorID]["NEWS"][] = $value;
				$arNewsId[$value["ID"]] = $value["ID"];
			}
		};

		unset($usersList[$currentUserId]);

		$arResult["AUTHORS"] = $usersList;

		$arResult["COUNT_NEWS"] = count($arNewsId);
		$this-> SetResultCacheKeys("COUNT_NEWS");
	}
	$this->includeComponentTemplate();
} else {
	$this->AbortResultCache();
}
$APPLICATION->SetTitle(GetMessage("EX_TITLE", ['#COUNT_NEWS#' => $arResult["COUNT_NEWS"]]));
?>