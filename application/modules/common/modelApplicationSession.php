<?php use framework as F;

class ModelApplicationSession extends F\ModelSession
{
    public static function checkSession()
    {
        $activeUser = self::getData("user", null);
        if ($activeUser != null)
        {
            // Check user data to the database in case something has changed
            $table = new ModelDatabaseTableUser();
            $dbUser = $table->getRecordById($activeUser["id"]);
            if (F\arrayGet($dbUser, "is_active") !== 1)
            {
                self::destroySession();
                $activeUser = null;
            }
            else
            {
                // Refresh user data in the session
                unset($dbUser["password"]);
                self::setData("user", $dbUser);
            }
        }
        return $activeUser != null;
    }
}
