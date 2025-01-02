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

        $this->database = F\arrayGet(CONFIG_DATA, "database");
        $host = F\arrayGet(CONFIG_DATA, "server");
        $user = F\arrayGet(CONFIG_DATA, "username");
        $password = F\arrayGet(CONFIG_DATA, "password");

        parent::__construct($host, $user, $password);

        $error = $this->getLastError();
        if ($error != "")
        {
            $this->log->writeMessage("Error connecting:");
            $this->log->writeMessage("Host    : " . var_export($host, true));
            $this->log->writeMessage("User    : " . var_export($user, true));
            $this->log->writeMessage("Database: " . var_export($this->database, true));
            $this->log->writeMessage("Table   : " . var_export($this->table, true));
            $this->log->writeMessage($error);
        }
    }
}
