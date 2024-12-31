<?php use framework as F;

/* Application controller */

class ControllerApplication extends F\ControllerBase
{
    public function executeAction($action, $level, $parameters)
    {
        // $level = access level:
        // 0 - always available
        // 1 - configuration must be OK, log in not required
        // 2 - configuration must be OK and must be logged in

        $controllerName = get_class($this);
        define("APP_LOG", new F\ModelLogger("application"));
        APP_LOG->writeMessage("------------------------------ Application start ------------------------------");
        APP_LOG->writeMessage("Controller: '{$controllerName}'");
        APP_LOG->writeMessage("Action    : '{$action}'");
        APP_LOG->writeMessage("Level     : {$level}");
        APP_LOG->writeMessage("Parameters:");
        APP_LOG->writeDataArray($parameters);

        APP_LOG->writeMessage("Execute action");
        return $this->$action($parameters);
    }

    protected function showWrongUri()
    {
        $pageData = [
            "sub_title" => "Wrong URI"
        ];
        return $this->showPage("WrongUri", $pageData);
    }

    private function showPage($pageName, $pageData)
    {
        APP_LOG->writeMessage("Generate color theme");
        ModelColorTheme::generateTheme();
        APP_LOG->writeMessage("Create view for '{$pageName}'");
        $view = new ViewApplication($pageName, $pageData);
        APP_LOG->writeMessage("Generate view");
        return $view->generateOutput();
    }
}
