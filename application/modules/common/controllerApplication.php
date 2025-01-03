<?php use framework as F;

/* Application controller */

class ControllerApplication extends F\ControllerBase
{
    protected $log;


    public function __construct()
    {
        // TODO: time zone must be set before starting the framework, else the framework log shows the wrong time
        date_default_timezone_set(ModelSettings::getSetting("time_zone", DEFAULT_TIME_ZONE));
        $this->log = new F\ModelLogger("application");
        $this->log->writeMessage("------------------------------ Application start ------------------------------");
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

        $isConfigurationOk = ModelConfiguration::checkConfiguration();
        $isSessionValid = false;

        $this->log->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        $this->log->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        // Check the setup, only for level 1 or higher
        if (!$isConfigurationOk and $level >= 1) {
            $this->log->writeMessage("Redirect to: configuration");
            $this->gotoLocation("configuration");
        }

        // Do not show configuration page if the configuration is created
        if ($isConfigurationOk and $action == "showConfiguration")
        {
            $this->log->writeMessage("Configuration already created, redirect to root");
            $this->gotoLocation("");
        }

        if ($action == "processApiCall")
        {
            $this->log->writeMessage("Process API call (see API log for details)");
            $result = ModelApi::processApiCall($isConfigurationOk, $isSessionValid);
            // API call can result in a redirect, if the API call is made from a webpage
            $redirect = F\arrayGet($result, "redirect");
            if ($redirect !== null)
            {
                $this->log->writeMessage("API call results in redirect to '{$redirect}'");
                $this->setNextPageData($result);
                $this->gotoLocation($redirect);
            }
            // No redirect, return API result as JSON format
            return json_encode($result, JSON_PRETTY_PRINT);
        }
        $this->log->writeMessage("Execute action");
        return $this->$action($parameters);
    }

    protected function showPage($pageName, $pageData)
    {
        $this->log->writeMessage("Show page: '{$pageName}'");
        $this->log->writeMessage("Merge page data");
        $nextPageData = ModelApplicationSession::getData("next_page_data", []);
        ModelApplicationSession::clearData("next_page_data");
        // Merge page data without record
        $recordData = F\arrayGet($nextPageData, "record", []);
        unset($nextPageData["record"]);
        $pageData = array_merge($pageData, $nextPageData);
        // Merge record data, or add record data
        if (isset($pageData["record"]) and count($recordData) > 0)
        {
            $pageData["record"] = array_merge($pageData["record"], $recordData);
        }
        elseif (count($recordData) > 0)
        {
            $pageData["record"] = $recordData;
        }
        $this->log->writeMessage("Generate color theme");
        ModelColorTheme::generateTheme();
        $this->log->writeMessage("Create view for '{$pageName}'");
        $view = new ViewApplication($pageName, $pageData);
        $this->log->writeMessage("Generate view");
        return $view->generateOutput();
    }

    protected function showLandingPage()
    {
        $this->gotoLocation(ModelSettings::getSetting("landing_page", DEFAULT_LANDING_PAGE));
    }

    protected function showWrongUri()
    {
        $pageData = [
            "sub_title" => "Wrong URI"
        ];
        return $this->showPage("WrongUri", $pageData);
    }

    protected function setNextPageData($pageData)
    {
        // Prepare next page data in case of a redirect
        ModelApplicationSession::setData("next_page_data", $pageData);
    }
}
