<?php use framework as F;

/* Model for handling the configuration */


class ModelConfiguration
{
    const configFile = ABS_PATH . CONFIG_FOLDER . "config.php";

    const defaultConfig = [
        "server"        => "localhost",
        "database"      => "",
        "username"      => "",
        "password"      => "",
        "ssl_domain"    => ""
    ];


    public static function checkConfiguration($silent=false)
    {
        $log = new F\ModelLogger("application");
        // Check for configuration file
        if (!file_exists(self::configFile))
        {
            if (!$silent)
            {
                $log->writeMessage("The configuration file does not exist (". self::configFile . ")");
            }
            return false;
        }
        return true;
    }

    public static function writeConfigurationFile($configData)
    {
        // Merge with default data, missing data will have default values and can be changed
        $configData = array_merge(self::defaultConfig, $configData);
        $output = "<?php\n\n";
        $output .= "/* Configuration file for your server settings */\n\n";
        $output .= "\$configurationData = ";
        $output .= var_export($configData, true);
        $output .= ";\n";
        file_put_contents(self::configFile, $output);
    }

    public static function readConfigurationFile()
    {
        $configData = self::defaultConfig;
        if (file_exists(self::configFile))
        {
            ob_start();
            include self::configFile;
            ob_get_clean();
            // Merge defaults with configuration data to make sure all config data exists
            array_merge($configData, $configurationData);
        }
        return $configData;
    }
}
