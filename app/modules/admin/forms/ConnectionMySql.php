<?php

namespace crudle\app\admin\forms;

use crudle\app\admin\enums\Db_Driver;

/**
 * ConnectionMySql is the model behind the connection form.
 */
class ConnectionMySql extends Connection
{
    // replace with trait
    const DefaultHost = 'localhost';
    const DefaultSchema = 'information_schema';

    public $driver = Db_Driver::MySQL;

    protected function prepareDbConfig()
    {
        $host = $this->useHost();
        // $database = $this->useDatabase(); // don't persist the user dbname
        $this->dsn = "$this->driver:host=$host;dbname=" . self::DefaultSchema; // mysql only

        $this->_dbConfig = [
            'class' => 'yii\db\Connection',
            'dsn' => $this->dsn,
            // 'driverName' => $this->driver, // odbc only
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8', // ?
        ];
    }

    public function useHost()
    {
        return !empty($this->host) ? $this->host : self::DefaultHost;
    }

    public function useDatabase()
    {
        return !empty($this->database) ? $this->database : self::DefaultSchema;
    }
}
