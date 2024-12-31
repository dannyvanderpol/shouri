<?php use framework as F;

/* Application controller */

class ControllerApplication extends F\ControllerBase
{
    public function executeAction($action, $level, $parameters)
    {
        define("APP_LOG", new F\ModelLogger("application"));
        APP_LOG->writeMessage("------------------------------ Application start ------------------------------");
        APP_LOG->writeMessage("Action    : '{$action}'");
        APP_LOG->writeMessage("Level     : {$level}");
        APP_LOG->writeMessage("Parameters:");
        APP_LOG->writeDataArray($parameters);

        return $this->$action($parameters);
    }

    protected function showWrongUri()
    {
        return $this->showPage("WrongUri");
    }

    private function showPage($pageName)
    {
        ModelColorTheme::generateTheme();
        $view = new ViewApplication($pageName);
        return $view->generateOutput();
    }
}
