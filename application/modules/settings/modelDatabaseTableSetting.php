<?php use framework as F;

class ModelDatabaseTableSetting extends ModelDatabaseTableBase
{
    public function __construct()
    {
        $this->table = "setting";
        $this->fields = [
            (new F\ModelDatabaseField())->name("module_name"  )->type("VARCHAR(200)")->isRequired(true),
            (new F\ModelDatabaseField())->name("setting_name" )->type("VARCHAR(200)")->isRequired(true),
            (new F\ModelDatabaseField())->name("setting_value")->type("VARCHAR(200)")->isRequired(true)
        ];
        $this->defaultRecords = [
            [ "module_name" => "administrator", "setting_name" => "database_version", "setting_value" => DATABASE_VERSION     ],
            [ "module_name" => "administrator", "setting_name" => "time_zone",        "setting_value" => DEFAULT_TIME_ZONE    ],
            [ "module_name" => "administrator", "setting_name" => "landing_page",     "setting_value" => DEFAULT_LANDING_PAGE ],
            [ "module_name" => "administrator", "setting_name" => "theme_color",      "setting_value" => DEFAULT_COLOR        ]
        ];
        parent::__construct();
    }
}
