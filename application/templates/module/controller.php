<?php

class Controller extends ControllerApplication
{
    protected function show()
    {
        $pageData = [
            "sub_title" => ""
        ];
        return $this->showPage("", $pageData);
    }
}
