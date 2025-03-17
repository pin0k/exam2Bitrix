<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

AddEventHandler("main", "OnBuildGlobalMenu", "MyOnBuildGlobalMenu");

function MyOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu) {
    global $USER;

    if (!$USER->IsAdmin()) {
        $arGroups = CUser::GetUserGroupList($USER->GetID());
        while($group = $arGroups->Fetch()) {
            if(intval($group["GROUP_ID"]) == "5") {
                foreach($aGlobalMenu as $key => $data) {
                    if(!in_array("global_menu_content", $data)) {
                        unset($aGlobalMenu[$key]);
                    }
                };
                foreach($aModuleMenu as $key => $data) {
                    if($data["items_id"] !== "menu_iblock_/news") {
                        unset($aModuleMenu[$key]);
                    }
                };
               
            }       
        }
    }
}

?>