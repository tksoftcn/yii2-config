<?php
namespace tksoft\config\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Json;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $key
 * @property string $value
 * @property integer $catid
 * @property string $type
 * @property integer $isrequired
 * @property integer $min
 * @property integer $max
 * @property string $data
 * @property string $rule
 * @property integer $displayorder
 * @property string $remark
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class ConfigTable extends \yii\db\ActiveRecord
{

    const TYPE_NUMBER = 'number';

    const TYPE_TEXT = 'text';

    const TYPE_TEXTAREA = 'textarea';

    const TYPE_RADIO = 'radio';

    const TYPE_DROPDOWNLIST = 'dropdownlist';

    const TYPE_CHECKBOX = 'checkbox';

    const TYPE_FILE = 'file';

    const TYPE_IMAGE = 'image';

    const TYPE_USERGROUP = 'usergroup';

    const RULE_URL = 'url';

    const RULE_EMAIL = 'email';

    const RULE_MOBILE = 'mobile';

    /**
     * Encoding/Decoding variable with the specified coding method values
     */
    const CODING_JSON = 'json';

    const CODING_SERIALIZE = 'serialize';

    /**
     * Method for coding and decoding
     * serialize or json
     * 
     * @var string default static::CODING_JSON
     * @see init()
     */
    public $coding;

    /**
     * Determine whether `value` has decoded before getAttribute() is called
     * 
     * @var boolean
     */
    private $_prepared = false;
    
    public static $cacheKey = 'tksoft.config';
    
    public function init() {
        if (empty($this->coding))
            $this->coding = self::CODING_JSON;
            
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className()
            ],
            'BlameableBehavior' => [
                'class' => BlameableBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'key',
                    'type'
                ],
                'required'
            ],
            [
                [
                    'remark',
                    'data'
                ],
                'string'
            ],
            [
                [
                    'value'
                ],
                'safe'
            ],
            [
                [
                    'catid',
                    'isrequired',
                    'min',
                    'max',
                    'displayorder',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'remark'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'key',
                    'type',
                    'rule'
                ],
                'string',
                'max' => 32
            ],
            [
                [
                    'key'
                ],
                'unique'
            ],
            [
                [
                    'displayorder',
                    'min',
                    'max',
                    'isrequired'
                ],
                'default',
                'value' => 0
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('config', 'ID'),
            'name' => Yii::t('config', 'Name'),
            'key' => Yii::t('config', 'Key'),
            'value' => Yii::t('config', 'Value'),
            'catid' => Yii::t('config', 'Catid'),
            'type' => Yii::t('config', 'Type'),
            'isrequired' => Yii::t('config', 'Isrequired'),
            'min' => Yii::t('config', 'Min'),
            'max' => Yii::t('config', 'Max'),
            'data' => Yii::t('config', 'Data'),
            'rule' => Yii::t('config', 'Rule'),
            'remark' => Yii::t('config', 'Remark'),
            'displayorder' => Yii::t('config', 'Displayorder'),
            'created_at' => Yii::t('config', 'Created At'),
            'updated_at' => Yii::t('config', 'Updated At'),
            'created_by' => Yii::t('config', 'Created By'),
            'updated_by' => Yii::t('config', 'Updated By')
        ];
    }

    /**
     * get category
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CategoryTable::className(), [
            'id' => 'catid'
        ]);
    }

    /**
     * build select array from data attribute for dropdownlist / checkbox
     *
     * @return multitype:|multitype:Ambigous <>
     */
    public function getSelectList()
    {
        if (empty($this->data))
            return [];
        
        $arr = array_filter(explode(PHP_EOL, $this->data));
        $res = [];
        if (! empty($arr)) {
            foreach ($arr as $line) {
                $tmp = explode('|', $line);
                if (! empty($tmp) && count($tmp) == 2) {
                    $res[$tmp[0]] = $tmp[1];
                }
            }
        }
        return $res;
    }

    /**
     * get all field types
     *
     * @return multitype:string
     */
    public static function getFieldTypes()
    {
        return [
            self::TYPE_NUMBER => Yii::t('config', self::TYPE_NUMBER),
            self::TYPE_TEXT => Yii::t('config', self::TYPE_TEXT),
            self::TYPE_TEXTAREA => Yii::t('config', self::TYPE_TEXTAREA),
            self::TYPE_RADIO => Yii::t('config', self::TYPE_RADIO),
            self::TYPE_DROPDOWNLIST => Yii::t('config', self::TYPE_DROPDOWNLIST),
            self::TYPE_CHECKBOX => Yii::t('config', self::TYPE_CHECKBOX),
            self::TYPE_FILE => Yii::t('config', self::TYPE_FILE),
            self::TYPE_IMAGE => Yii::t('config', self::TYPE_IMAGE)
        ];
    }

    /**
     * get extra validate rule for config item
     *
     * @return multitype:string
     */
    public static function getExtraRules()
    {
        return [
            self::RULE_URL => Yii::t('config', self::RULE_URL),
            self::RULE_EMAIL => Yii::t('config', self::RULE_EMAIL),
            self::RULE_MOBILE => Yii::t('config', self::RULE_MOBILE)
        ];
    }

    /**
     * encode value to json/serialize format
     *
     * @see \yii\db\BaseActiveRecord::beforeSave($insert)
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->value)) {
                $this->value = $this->encode($this->value);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * clear cache
     * 
     * @see \tksoft\config\components\Config
     * @see \yii\db\BaseActiveRecord::afterSave($insert, $changedAttributes)
     */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $t = Yii::$app->cache->delete($this::$cacheKey);
        if (!$t)
            Yii::warning('delete cache '.$this::$cacheKey.' failed','debug2');
    }
    
    public static function buildCache() {
        $data = self::getAllConfig();
        Yii::$app->cache->set(self::$cacheKey, $data);
    }
    
    public static function getAllConfig() {
        $configs = self::find()->select(['key','value'])->all();
        $res = [];
        foreach ($configs as $config) {
            // calling $config->value is important!!
            $res[$config->key] = $config->value;
        }
        return $res;
    }
    
    /**
     * We convert config value to json/serialize format before saving to db
     * So we must decode it before using the value
     * 
     * @see \yii\db\BaseActiveRecord::__get($name)
     */
    public function __get($name) {
        $value = parent::__get($name);        
        if ($name == 'value' && !$this->_prepared) {
            $value = $this->decode($value);
            $this->_prepared = true;
        }
        return $value;
    }
    /**
     * Encoding variable with the specified coding method
     * 
     * @param mixed $value            
     * @return mixed
     * @throws Exception
     */
    public function encode($value)
    {
        switch ($this->coding) {
            case self::CODING_JSON:
                return Json::encode($value);
                break;
            case self::CODING_SERIALIZE:
                return serialize($value);
                break;
            default:
                throw new Exception("Config.coding \"{$this->coding}\" is invalid.");
                break;
        }
    }

    /**
     * Decoding variable with the specified coding method
     * 
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
