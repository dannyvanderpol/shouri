<?php use framework as F;

class ModelApplicationSession extends F\ModelSession
{
    public static function checkSession()
    {
        $activeUser = self::getData("user", null);
        if ($activeUser != null)
        {
            // Check user data to the database in case something has changed
            $id = $activeUser["id"];
            $activeUser = null;
            $table = new ModelDatabaseTableUser();
            if ($table->isConnected())
            {
                $dbUser = $table->getRecordById($id);
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

    public static function createSession($data)
    {
        $result = ["result" => false, "message" => "Could not log in to the server."];
        $fields = [
            ["email",    "email address"],
            ["password", "password"     ]
        ];
        foreach ($fields as $field)
        {
            if (!isset($data[$field[0]]) or $data[$field[0]] == "")
            {
                $result["message"] = "The {$field[1]} is empty.";
                return $result;
            }
        }
        $user = new ModelDatabaseTableUser();
        if (!$user->isConnected())
        {
            return $result;
        }
        $records = $user->getRecords("email = '{$data["email"]}'");
        if (count($records) != 1)
        {
            $result["message"] = "The email address is not valid.";
            return $result;
        }
        $record = $records[0];
        $filter = "email = '{$record["email"]}'";
        // Check for password
        if ($user->hash($data["password"]) != $record["password"])
        {
            $user->updateRecord(["log_in_fail" => $record["log_in_fail"] + 1], $filter);
            if ($record["log_in_fail"] >= $user->lockMaxAttempts) {
                // Too many failed attempts
                $diff = ceil(time() - $record["last_log_in"]) / 60;
                if ($diff > $user->lockTimeout)
                {
                    // Timeout is passed
                    $user->updateRecord(["log_in_fail" => 0, "last_log_in" => time()], $filter);
                }
                else
                {
                    $tryAgain = ceil($user->lockTimeout - $diff);
                    $result["message"] = "You cannot log in because of too many failed attempts. You can try again after $tryAgain minutes.";
                    return $result;
                }
            }
            $result["message"] = "The password is not valid.";
            return $result;
        }
        if ($record["is_active"] != 1)
        {
            $result["message"] = "Your account is not active, contact your administrator.";
            return $result;
        }
        // Log in passed, update record and create session
        $user->updateRecord(["last_log_in" => time(), "log_in_fail" => 0], $filter);
        unset($record["password"]);
        self::setData("user", $record);
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }
}
