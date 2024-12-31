<?php use framework as F;

/* Application controller */

class ControllerApplication extends F\ControllerBase
{
    protected function showWrongUri()
    {
        return $this->showPage("WrongUri");
    }

    private function showPage($pageName)
    {
        $view = new ViewApplication($pageName);
        return $view->generateOutput();
    }
}
