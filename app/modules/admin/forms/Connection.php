<?php

namespace crudle\app\admin\forms;

use Yii;
use yii\base\Model;

/**
 * Connection is the model behind the connection form.
 */
abstract class Connection extends Model
{
    public $dsn;
    public $driver;
    public $host; // default 'localhost'
    public $port;
    public $username;
    public $password;
    public $database;
    public $rememberMe = false;
    protected $_dbConfig;

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

        $this->prepareDbConfig();

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

    abstract protected function prepareDbConfig();

    abstract public function useHost();

    abstract public function useDatabase();

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
