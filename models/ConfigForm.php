<?php
namespace tksoft\config\models;

use Yii;
use yii\base\Model;

/**
 * Config form used for default controller
 *
 * @author tongke
 *        
 */
class ConfigForm extends Model
{

    public $cats = [];

    public $catSettings = [];

    /**
     * 设置项
     *
     * @var array
     */
    public $settings = [];

    private $_rules = [];

    private $_labels = [];
    
    private $_hints = [];

    public $_setPrefix = 'tksoftParam';
    /**
     * used for __get and __set
     * 
     * @var array
     */
    private $_holder = [];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->cats = CategoryTable::getDropDownList();
        
        $this->settings = ConfigTable::find()->addOrderBy('displayorder DESC')->all();
        if (! empty($this->settings)) {
            foreach ($this->settings as $key => $setting) {
                // 赋值
                $this->{$this->_setPrefix . $setting->id} = $setting->value;
                // 将设置项进行分类
                $this->catSettings[$setting->catid][] = $setting;
                
                // 设置标签
                $this->setLabel($setting->id, $setting->name);
                $this->setHint($setting->id, $setting->remark);
                
                // 设置规则
                if ($setting->isrequired) {
                    $ruleName = 'requiredSet' . $setting->id;
                    $ruleParam = [
                        [
                            $this->_setPrefix . $setting->id
                        ],
                        'required'
                    ];
                    $this->addRule($ruleName, $ruleParam);
                }
                
                switch ($setting->type) {
                    case ConfigTable::TYPE_TEXT:
                    case ConfigTable::TYPE_TEXTAREA:
                        $ruleName = 'stringSet' . $setting->id;
                        $ruleParam = [
                            [
                                $this->_setPrefix . $setting->id
                            ],
                            'string',
                            'min' => ($setting->min > 0) ? $setting->min : null,
                            'max' => ($setting->max > 0) ? $setting->max : null
                        ];
                        $this->addRule($ruleName, $ruleParam);
                        break;
                    
                    case ConfigTable::TYPE_NUMBER:
                        $ruleName = 'numberSet' . $setting->id;
                        $ruleParam = [
                            [
                                $this->_setPrefix . $setting->id
                            ],
                            'number',
                            'min' => ($setting->min > 0) ? $setting->min : null,
                            'max' => ($setting->max > 0) ? $setting->max : null
                        ];
                        $this->addRule($ruleName, $ruleParam);
                        break;
                    
                    case ConfigTable::TYPE_RADIO:
                        $ruleName = 'boolSet' . $setting->id;
                        $ruleParam = [
                            [
                                $this->_setPrefix . $setting->id
                            ],
                            'boolean'
                        ];
                        $this->addRule($ruleName, $ruleParam);
                        break;
                    
                    case ConfigTable::TYPE_DROPDOWNLIST:
                        $ruleName = 'safeSet' . $setting->id;
                        $ruleParam = [
                            [
                                $this->_setPrefix . $setting->id
                            ],
                            'safe'
                        ];
                        $this->addRule($ruleName, $ruleParam);
                        break;
                    
                    case ConfigTable::TYPE_CHECKBOX:
                        $ruleName = 'eachSet' . $setting->id;
                        $ruleParam = [
                            [
                                $this->_setPrefix . $setting->id
                            ],
                            'each',
                            'rule' => ['safe']
                        ];
                        $this->addRule($ruleName, $ruleParam);
                        break;
                        
                    case ConfigTable::TYPE_FILE:
                        break;
                    case ConfigTable::TYPE_IMAGE:
                        break;
                    default:
                        break;
                }
                
                if (! empty($setting->rule)) {
                    $ruleName = $setting->rule . 'Set' . $setting->id;
                    $ruleParam = [
                        [
                            $this->_setPrefix . $setting->id
                        ],
                        $setting->rule
                    ];
                    $this->addRule($ruleName, $ruleParam);
                }
            }
        }
    }

    public function rules()
    {
        return $this->_rules;
    }

    public function addRule($name, $param)
    {
        $this->_rules[$name] = $param;
    }

    public function attributeLabels()
    {
        return $this->_labels;
    }

    public function getAttributeLabel($attribute)
    {
        return isset($this->_labels[$attribute]) ? $this->_labels[$attribute] : '';
    }
    public function getAttributeHint($attribute)
    {
        return isset($this->_hints[$attribute]) ? $this->_hints[$attribute] : '';
    }
    private function setLabel($attribute, $label)
    {
        $this->_labels[$this->_setPrefix . $attribute] = $label;
    }
    private function setHint($attribute, $hint)
    {
        $this->_hints[$this->_setPrefix . $attribute] = $hint;
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Component::__get()
     */
    public function __get($name) {
        if (strncmp($name, $this->_setPrefix, strlen($this->_setPrefix)) === 0) {
            return (isset($this->_holder[$name])) ? $this->_holder[$name] : '';
        }
        
        return parent::__get($name);
    }
    
    /**
     * (non-PHPdoc)
     * @see \yii\base\Component::__set()
     */
    public function __set($name, $value) {
        if (strncmp($name, $this->_setPrefix, strlen($this->_setPrefix)) === 0) {
            $this->_holder[$name] = $value;
            return;
        }
        return parent::__set($name,$value);
    }
}