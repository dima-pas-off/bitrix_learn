<?

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Engine\ActionFilter;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();



class NewsDetailController extends Controller {


    function configureActions()
    {
        return [
            "complaint" => [
                "-prefilters" => [
                    ActionFilter\Authentication::class
                ]
            ]
        ];
    }

    function complaintAction($id) {
        
        $idIblockComplains = 8;

        Loader::includeModule("iblock");
        AddMessage2Log("dd");
        $currentUserEntity = CurrentUser::get();
        AddMessage2Log($currentUserEntity);
        $userInfo = "";

        if(!is_null($currentUserEntity->getId())) {
            $userInfo .= $currentUserEntity->getId() . ' ' . $currentUserEntity->getLogin() . ' ' . $currentUserEntity->getLastName();
        }
        else {
            $userInfo .= "Пользователь не авторизован";
        }

        $dateTime = (new DateTime())->format("d.m.y");

        $element = new CIBlockElement;
        $arr = [
            "IBLOCK_ID" => $idIblockComplains,
            "NAME" => "Жалоба на новость",
            "ACTIVE" => "Y",
            "ACTIVE_FROM" => $dateTime,
            "PROPERTY_VALUES" => [
                "USER" => $userInfo,
                "NEWS" => $id
            ]
        ];

        $createdElement = $element->Add($arr);

        if(!$createdElement) {
            $this->addError(new Error("Не удалось создать элемент", "error_create_element"));
            return null;
        }

        return $createdElement;

}
}