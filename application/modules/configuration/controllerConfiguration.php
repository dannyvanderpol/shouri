<?php

class ControllerConfiguration extends ControllerApplication
{
    protected function showConfiguration()
    {
        $pageData = [
            "sub_title" => "Configuration"
        ];
        return $this->showPage("Configuration", $pageData);
    }
}
