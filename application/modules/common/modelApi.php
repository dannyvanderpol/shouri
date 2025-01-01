<?php use framework as F;

/* Process the API calls */

class ModelApi
{
    private static $log;


    public static function processApiCall($isConfigurationOk, $isSessionValid)
    {
        $result = ["result" => false, "message" => "Server error, try again later"];

        self::$log = new F\ModelLogger("api");
        self::$log->writeMessage("------------------------------ Process API call ------------------------------");
        self::$log->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        self::$log->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        self::$log->writeMessage("Result: " . var_export($result["result"], true));
        return json_encode($result, JSON_PRETTY_PRINT);
    }
}
