<?php

namespace crudle\app\admin\models\auth;

use crudle\app\admin\enums\Db_Driver;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    const DefaultHost = 'localhost';
    const DefaultSchema = 'information_schema';

    public $dsn;
    public $driver = Db_Driver::MySQL;
    public $host; // default 'localhost'
    public $port;
    public $username;
    public $password;
    public $database;
    public $rememberMe = false;
    private $_dbConfig;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['dsn', 'driver', 'host', 'port', 'database'], 'safe'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // validate the db connection
            ['dsn', 'validateConnection'],
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate())
            return false;

        $this->_prepareDbConfig();

        return true;
    }

    /**
     * @return array the validation rules.
     */
    public function attributeLabels()
    {
        return [
            // 'dsn' => Yii::t('app', 'Data Source Name'),
            'driver' => Yii::t('app', 'Connection Type'),
            'host' => Yii::t('app', 'Server Address'),
            // 'port' => Yii::t('app', 'Port'),
            'database' => Yii::t('app', 'Database Name'),
            'username' => Yii::t('app', 'DB Username'),
            'password' => Yii::t('app', 'DB Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
        ];
    }

    /**
     * @return array the attribute label hints.
     */
    public function attributeHints()
    {
        return [
            // 'driver' => Yii::t('app', 'Supported database type'),
            // 'host' => Yii::t('app', 'FQDN or IP address'),
        ];
    }

    /**
     * Validates the credentials.
     * This method serves as the inline validation for credentials.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateConnection($attribute, $params)
    {
        $connection = new \yii\db\Connection([
            'dsn' => $this->dsn, // must be prepared - beforeValidate()
            'username' => $this->username,
            'password' => $this->password,
        ]);
        try {
            $connection->open();
        }
        catch (\yii\db\Exception $e) {
            $this->addError($attribute, $e->errorInfo[2]);
        }

        if (!$connection->isActive) {
            $this->addError($attribute, 'Database connection is not active');
        }
        return true;
    }

    /**
     * Opens a connection using the provided connection details.
     * @return bool whether the connection is opened successfully
     */
    public function establishConnection()
    {
        // register db component in app
        Yii::$app->set('db', $this->_dbConfig);
        // open db connection
        Yii::$app->db->open();
        return Yii::$app->db->isActive;
        // $this->rememberMe ? 3600 * 24 * 30 : 0); // ? set session expiry
    }

    private function _prepareDbConfig()
    {
        $host = $this->useHost();
        $database = $this->useDatabase();
        $this->dsn = "$this->driver:host=$host;dbname=$database"; // mysql only

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

    /**
     * @return void the database config properties.
     */
    public function setDbConfig($dbConfig)
    {
        $this->_dbConfig = $dbConfig;
    }

    /**
     * @return array the database config properties.
     */
    public function getDbConfig()
    {
        return $this->_dbConfig;
    }
}
