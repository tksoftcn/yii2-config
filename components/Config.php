<?php
namespace tksoft\config\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Config extends Component {
    /**
     * Encoding/Decoding variable with the specified coding method values
     */
    const CODING_JSON = 'json';
    const CODING_SERIALIZE = 'serialize';
    /**
     * Method for coding and decoding
     * serialize or json
     * @var string default static::CODING_JSON
     * @see init()
     */
    public $coding;
    /**
     * The ID of the connection component
     * @var string
     */
    public $idConnection = 'db';
    /**
     * Config table name
     * @var string
     */
    public $tableName = '{{%config}}';
    /**
     * The ID of the cache component
     * @var string
     */
    public $idCache;
    /**
     * The key identifying the value to be cached
     * @var string
     */
    public $cacheKey = 'tksoft.config';
    /**
     * The number of seconds in which the cached value will expire. 0 means never expire.
     * @var integer
     */
    public $cacheDuration = 3600;
    /**
     * Config data
     * @var array
     */
    private $_data;
    /**
     * Returns the database connection component.
     * @var \yii\db\Connection the database connection.
     */
    private $_db;
    /**
     * @var \yii\caching\Cache
     */
    private $_cache;
    /**
     * @inheritdoc
     */
    public function init()
    {
        // Get coding
        $this->coding = !empty($this->coding) ? $this->coding : self::CODING_JSON;
        // Get db component
        $this->_db = Yii::$app->get($this->idConnection);
        if(!$this->_db instanceof \yii\db\Connection) {
            throw new Exception("Config.idConnection \"{$this->idConnection}\" is invalid.");
        }
        // Get cache component
        if($this->idCache !== NULL) {
            $this->_cache = Yii::$app->get($this->idCache);
            if(!$this->_cache instanceof \yii\caching\Cache) {
                throw new Exception("Config.idCache \"{$this->idCache}\" is invalid.");
            }
        }
        parent::init();
    }
    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        if ($this->_data === null) {
            if($this->_cache !== null) {
                $cache = $this->_cache->get($this->cacheKey);
                if($cache === false) {
                    $this->_data = $this->_getDataFromDb();
                    $this->_setCache();
                } else {
                    $this->_data = $cache;
                }
            } else {
                $this->_data = $this->_getDataFromDb();
            }
        }
        return $this->_data;
    }
    /**
     * Get data from database
     * @return array
     */
    private function _getDataFromDb()
    {
        return ArrayHelper::map($this->_db->createCommand("SELECT * FROM {$this->tableName}")->queryAll(), 'key', 'value');
    }
    /**
     * Set cache
     */
    private function _setCache()
    {
        if($this->_cache !== null) {
            $this->_cache->set($this->cacheKey, $this->_data, $this->cacheDuration);
        }
    }
    /**
     * Get config var
     * @param string/array $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (is_array($name)) {
            $return = [];
            foreach ($name as $key => $value) {
                if (is_int($key)) {
                    $return[$value] = $this->_get($value, $default);
                } else {
                    $return[$key] = $this->_get($key, $value);
                }
            }
            return $return;
        }
        return $this->_get($name, $default);
    }
    /**
     * Find and decode config var
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    private function _get($name, $default = null)
    {
        $data = $this->getData();
        return array_key_exists($name, $data) ? $this->decode($data[$name]) : $default;
    }
    /**
     * @inheritdoc
     */
    public function getAll()
    {
        $return = [];
        foreach ($this->getData() as $key => $data) {
            $return[$key] = $this->get($key);
        }
        return $return;
    }

    /**
     * Decoding variable with the specified coding method
     * @param mixed $value
     * @return mixed
     * @throws Exception
     */
    public function decode($value)
    {
        switch ($this->coding) {
            case self::CODING_JSON:
                return Json::decode($value);
                break;
            case self::CODING_SERIALIZE:
                return unserialize($value);
                break;
            default:
                throw new Exception("Config.coding \"{$this->coding}\" is invalid.");
                break;
        }
    }
    
}