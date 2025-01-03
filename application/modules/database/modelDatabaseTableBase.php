<?php use framework as F;

class ModelDatabaseTableBase extends F\ModelDatabaseTable
{
    protected $log;

    public function __construct()
    {
        // Insert ID field as first field, for every table the same
        array_unshift($this->fields,
            (new F\ModelDatabaseField())->name("id")->type("INT")->isRequired(true)->autoIncrement(true)->isKey(true));

        $this->log = new F\ModelLogger("database");

        $configData = ModelConfiguration::readConfigurationFile();

        $this->database = F\arrayGet($configData, "database");
        $host = F\arrayGet($configData, "server");
        $user = F\arrayGet($configData, "username");
        $password = F\arrayGet($configData, "password");

        parent::__construct($host, $user, $password);

        if (!$this->isConnected())
        {
            $this->log->writeMessage("Error connecting:");
            $this->log->writeMessage("Host    : " . var_export($host, true));
            $this->log->writeMessage("User    : " . var_export($user, true));
            $this->log->writeMessage("Database: " . var_export($this->database, true));
            $this->log->writeMessage("Table   : " . var_export($this->table, true));
            $this->log->writeMessage($this->getLastError());
        }
    }

    public function getRecordById($id)
    {
        $record = [];
        if ($id > 0)
        {
            $records = $this->getRecords(["filter" => "id = {$id}"]);
            if (count($records) == 1)
            {
                $record = $records[0];
            }
        }
        return $record;
    }
}
