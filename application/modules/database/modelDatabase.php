<?php

/* Direct access to the database */

class ModelDatabase extends ModelDatabaseTableBase
{
    public function tableExist($table)
    {
        return $this->interface->tableExist($this->database, $table);
    }

    public function dropTable($table)
    {
        return $this->interface->dropTable($this->database, $table);
    }
}
