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

    public static function createConfiguration($data)
    {
        $fields = [
            [ "host_name",             "host name"                     ],
            [ "database",              "database name"                 ],
            [ "db_user_name",          "database user name"            ],
            [ "db_password",           "database password"             ],
            [ "db_repeat_password",    "repeat database password"      ],
            [ "admin_email",           "administrator email address"   ],
            [ "admin_name",            "administrator name"            ],
            [ "admin_password",        "administrator password"        ],
            [ "admin_repeat_password", "repeat administrator password" ]
        ];

        $result = ["result" => false, "message" => "Failed to create the configuration."];
        foreach ($fields as $field)
        {
            if (!isset($data[$field[0]]) or $data[$field[0]] == "")
            {
                $result["message"] = "The {$field[1]} is empty";
                return $result;
            }
        }
        if ($data["db_password"] != $data["db_repeat_password"])
        {
            $result["message"] = "The repeat database password is not matching the database password";
            return $result;
        }
        if ($data["admin_password"] != $data["admin_repeat_password"])
        {
            $result["message"] = "The repeat administrator password is not matching the administrator password";
            return $result;
        }
        $configdata = self::defaultConfig;
        $configdata["server"] = $data["host_name"];
        $configdata["database"] = $data["database"];
        $configdata["username"] = $data["db_user_name"];
        $configdata["password"] = $data["db_password"];
        $result["result"] = self::writeConfigurationFile($configdata);
        if (!$result["result"])
        {
            $result["message"] = "The configuration file '" . self::configFile ."' could not be created.";
            return $result;
        }
        // Create user in the database
        $result = ["result" => false, "message" => "Failed to add the administrator user to the database."];
        $user = new ModelDatabaseTableUser();
        $error = $user->getLastError();
        if ($error != "")
        {
            $result["message"] = "Could not connect to the database:\n{$error}";
            return $result;
        }
        $record = [
            "id"        => 0,
            "email"     => $data["admin_email"],
            "name"      => $data["admin_name"],
            "password"  => $user->hash($data["admin_password"]),
            "is_active" => 1,
            "is_admin"  => 1
        ];
        if ($user->addRecord($record))
        {
            $result = ["result" => true, "message" => ""];
        }
        else
        {
            $result["message"] = "Could not add the user to the database:\n" . $user->getLastError();
        }
        return $result;
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
        return file_put_contents(self::configFile, $output) !== false;
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
            $configData = array_merge($configData, $configurationData);
        }
        return $configData;
    }
}
