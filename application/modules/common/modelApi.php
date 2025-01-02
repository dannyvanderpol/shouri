<?php use framework as F;

/* Process the API calls */

class ModelApi
{
    private static $log;


    public static function processApiCall($isConfigurationOk, $isSessionValid)
    {
        self::$log = new F\ModelLogger("api");
        self::$log->writeMessage("------------------------------ Process API call ------------------------------");
        self::$log->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        self::$log->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        // Get values from posted data
        $postedData = F\getPostedData();
        $action = F\arrayGet($postedData, "action");
        $record =  F\arrayGet($postedData, "record", []);
        $onSave = F\arrayGet($postedData, "on_save");
        $onDelete = F\arrayGet($postedData, "on_delete");
        $onFailure = F\arrayGet($postedData, "on_failure");
        $title =  F\arrayGet($postedData, "title");

        self::$log->writeMessage("Action          : " . var_export($action, true));
        self::$log->writeMessage("Has record data : " . var_export(count($record) > 0, true));
        self::$log->writeMessage("On save         : " . var_export($onSave, true));
        self::$log->writeMessage("On delete       : " . var_export($onDelete, true));
        self::$log->writeMessage("On failure      : " . var_export($onFailure, true));
        self::$log->writeMessage("Title           : " . var_export($title, true));

        // If the configuration is not OK and we are not trying to create one
        if (!$isConfigurationOk and $action != "create_configuration")
        {
            $result["message"] = "The configuration is invalid";
            return self::processResult($result, $onSuccess, $onFailure, $record, $title);
        }

        // If the session is not OK and we are not trying to create a cfiguration, log in or log out
        if (!$isSessionValid and $action != "create_configuration" and $action != "log_in" and $action != "log_out")
        {
            $result["message"] = "Unauthorized";
            return self::processResult($result, $onSuccess, $onFailure, $record, $title);
        }

        // Process action
        $result = ["result" => false, "message" => "Invalid action: '{$action}'."];
        switch (true)
        {
            case ($action == "create_configuration"):
                $result = ["result" => false, "message" => "There is already a configuration."];
                if (!$isConfigurationOk)
                {
                    self::$log->writeMessage("Create configuration");
                    $result = ModelConfiguration::createConfiguration($record);
                }
                break;
        }

        $onSuccess = $onSave;
        return self::processResult($result, $onSuccess, $onFailure, $record, $title);
    }

    private static function processResult($result, $onSuccess, $onFailure, $record, $title)
    {
        self::$log->writeMessage("Result : " . var_export($result["result"], true));
        if ($result["message"] != "")
        {
            self::$log->writeMessage("Message: " . var_export($result["message"], true));
        }
        $redirect = $onFailure;
        if ($result["result"])
        {
            $redirect = $onSuccess;
        }
        if ($redirect !== null)
        {
            $result["redirect"] = $redirect;
            $result["title"] = $title;
            if ($record !== null)
            {
                $result["record"] = $record;
            }

        }
        return $result;
    }
}
