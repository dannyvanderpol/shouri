<?php use framework as F;

class ModelApplicationSession extends F\ModelSession
{
    public static function checkSession()
    {
        $activeUser = self::getData("user", null);
        if ($activeUser != null)
        {
            // Check user data to the database in case something has changed
            $activeUser = null;
            $table = new ModelDatabaseTableUser();
            if ($table->isConnected())
            {
                $dbUser = $table->getRecordById($activeUser["id"]);
                if (F\arrayGet($dbUser, "is_active") === 1)
                {
                    $activeUser = $dbUser;
                }
            }
            if ($activeUser == null)
            {
                self::destroySession();
                $activeUser = null;
            }
            else
            {
                // Refresh user data in the session
                unset($activeUser["password"]);
                self::setData("user", $activeUser);
            }
        }
        return $activeUser != null;
    }
}
