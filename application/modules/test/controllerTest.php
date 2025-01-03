<?php use framework as F;

class ControllerTest extends ControllerApplication
{
    public function executeAction($action, $level, $parameters)
    {
        // Only execute when on local host
        if (!IS_LOCALHOST)
        {
            $this->log->writeMessage("Test URIs only allowed on localhost, redirecting to root");
            $this->gotoLocation("");
        }
        return parent::executeAction($action, $level, $parameters);
    }

    protected function showTestModals($parameters)
    {
        $pageData = [
            "sub_title" => "Test modals"
        ];
        return $this->showPage("TestModals", $pageData);
    }
}
