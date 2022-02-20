<?

use Bitrix\Main\Context;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;

$request = Context::getCurrent()->getRequest();
$idNews = $request->getQuery("ID");


if($idNews && $arParams["AJAX_COMPLAINT"] === "N") {
    
    $idNews = htmlspecialchars($idNews);
    $idNews = intval($idNews);

    if(!$idNews) {
        return;
    }

    $idIBlockNews = $arResult["IBLOCK_ID"];    
    $idIblockComplains = 8;


    $news = CIBlockElement::GetList([], ["IBLOCK_ID" => $idIBlockNews, "ID" => $idNews]);

    if(!$news) {
        return;
    }

    Loader::includeModule("iblock");

    $currentUserEntity = CurrentUser::get();
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
        echo "<p class='feedback-info-send-complaint'>Ошибка</p>";
        return;
    }

    echo "<p class='feedback-info-send-complaint'>Ваше мнение учтено, №$createdElement </p>";
}