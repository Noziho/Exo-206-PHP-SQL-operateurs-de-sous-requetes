<?php

class DB_Connect
{

    /**
     * @
     * var string to be used with a sprintf + Config file for cleaning code.
     */
    private static string $dsn = "mysql:host=%s;dbname=%s;charset=%s";
    private static ?PDO $objectPDO = null;


    /**
     * function to get a single instance of the class SingletonBD.
     * @return PDO|null
     */
    public static function dbConnect(): ?PDO
    {
        if (self::$objectPDO === null) {
            try {
                /**
                 * A local var dsn for use the global var dsn with a sprintf for use the Config file and clear the code.
                 */
                $dsn = sprintf(self::$dsn, Config::DB_SERVER, Config::DB_NAME, Config::DB_CHARSET);
                self::$objectPDO = new PDO($dsn, Config::DB_USERNAME, Config::DB_PASSWORD);
                self::$objectPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$objectPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$objectPDO;
    }

}