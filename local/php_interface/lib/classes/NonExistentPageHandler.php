<?
namespace Custom;




class NonExistentPageHandler {

    function handler() {
        
        if(defined("ERROR_404") && ERROR_404 === "Y")
        {
            \CEventLog::add([
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => \Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage()
            ]);
        }
    }

}

?>