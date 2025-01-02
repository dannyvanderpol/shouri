<?php use framework as F;

/* User table

Access levels: a string of hexadecimal values containing access levels for each table.
This is determined by the constant: ACCESS_INDEX in the database table model.
This user table has ACCESS_INDEX = 1, meaning the first character defines the access level.
Possible access levels:

0x0 = no access
0x1 = read access
0x2 = write access (create/modify records)
0x4 = delete access
0x8 = not used

Access levels can be combined:
0x3 = 0x1 + 0x2             = read and write access
0x7 = 0x1 + 0x2 + 0x4       = read, write and delete access
0xF = 0x1 + 0x2 + 0x4 + 0x8 = all access levels

*/

class ModelDatabaseTableUser extends ModelDatabaseTableBase
{
    public function __construct()
    {
        $this->table = "user";
        $this->fields = [
            (new F\ModelDatabaseField())->name("email"         )->type("VARCHAR(200)")->isRequired(true ),
            (new F\ModelDatabaseField())->name("name"          )->type("VARCHAR(200)")->isRequired(true ),
            (new F\ModelDatabaseField())->name("password"      )->type("VARCHAR(200)")->isRequired(true ),
            (new F\ModelDatabaseField())->name("is_active"     )->type("INT"         )->isRequired(true ),
            (new F\ModelDatabaseField())->name("is_admin"      )->type("INT"         )->isRequired(false),
            (new F\ModelDatabaseField())->name("access_levels" )->type("VARCHAR(200)")->isRequired(false),
            (new F\ModelDatabaseField())->name("last_log_in"   )->type("INT"         )->isRequired(false),
            (new F\ModelDatabaseField())->name("log_in_fail"   )->type("INT"         )->isRequired(false)
        ];
        parent::__construct();
    }

    public function hash($input)
    {
        return hash("sha256", $input);
    }
}
