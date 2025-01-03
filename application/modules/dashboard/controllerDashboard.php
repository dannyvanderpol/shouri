<?php

class ControllerDashboard extends ControllerApplication
{
    protected function showDashboard()
    {
        $pageData = [
            "sub_title" => "Dashboard",
            "items" => ModelDashboard::getDashboardItems()
        ];
        return $this->showPage("Dashboard", $pageData);
    }
}
