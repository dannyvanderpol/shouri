<?php use framework as F;

class ControllerSession extends ControllerApplication
{
    protected function showLogIn($parameters)
    {
        $pageData = [
            "sub_title" => "Log in",
            "redirect" => F\arrayGet($parameters, "redirect", "")
        ];
        return $this->showPage("LogIn", $pageData);
    }
}
