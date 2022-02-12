<?
namespace Custom;


class SendFeedbackFormHandler {


    function handler(&$event, &$lid, &$arFields) {

        $currentUser = \Bitrix\Main\Engine\CurrentUser::get();
        $idCurrentUser = $currentUser->getId();
        $fieldAuthor = $arFields["AUTHOR"];

        if(is_null($idCurrentUser)) {
            $arFields["AUTHOR"] = "Пользователь не авторизован, данные из формы:" . $fieldAuthor;
        }
        else {
            $loginCurrentUser = $currentUser->getLogin();
            $nameCurrentUser = $currentUser->getFullName();
            $arFields["AUTHOR"] = "Пользователь авторизован, $idCurrentUser $loginCurrentUser $nameCurrentUser, данные из формы $fieldAuthor";
        }

        \CEventLog::Add([
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "EVENT_FEEDBACK",
            "MODULE_ID" => "main",
            "DESCRIPTION" => "Замена данных в отсылаемом письме – " . $arFields["AUTHOR"]

        ]);

    }
}

?>