<?php

class ModelSettings
{
    public static function getSetting($settingName, $defaultValue)
    {
        $value = $defaultValue;
        $table = new ModelDatabaseTableSetting();
        $records = $table->getRecords(["filter" => "setting_name = '{$settingName}'"]);
        if (count($records) == 1)
        {
            $value = $records[0]["setting_value"];
        }
        return $value;
    }
}