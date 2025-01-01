<?php use framework as F;

/* Application controller */

class ControllerApplication extends F\ControllerBase
{
    private $log;

    public function __construct()
    {
        $this->log = new F\ModelLogger("application");
        $this->log->writeMessage("------------------------------ Application start ------------------------------");

        date_default_timezone_set("Europe/Amsterdam");
    }

    public function executeAction($action, $level, $parameters)
    {
        // $level = access level:
        // 0 - always available
        // 1 - configuration must be OK, log in not required
        // 2 - configuration must be OK and must be logged in

        $controllerName = get_class($this);
        $this->log->writeMessage("Controller: '{$controllerName}'");
        $this->log->writeMessage("Action    : '{$action}'");
        $this->log->writeMessage("Level     : {$level}");
        $this->log->writeMessage("Parameters:");
        $this->log->writeDataArray($parameters);

        $this->log->writeMessage("Execute action");
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
        $this->log->writeMessage("Generate color theme");
        ModelColorTheme::generateTheme();
        $this->log->writeMessage("Create view for '{$pageName}'");
        $view = new ViewApplication($pageName, $pageData);
        $this->log->writeMessage("Generate view");
        return $view->generateOutput();
    }
}
