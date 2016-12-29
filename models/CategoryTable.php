<?php
namespace tksoft\config\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%config_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $remark
 * @property integer $displayorder
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class CategoryTable extends \yii\db\ActiveRecord
{

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
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'name'
                ],
                'required'
            ],
            [
                [
                    'status',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                    'displayorder'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'remark'
                ],
                'string',
                'max' => 32
            ],
            [
                [
                    'status'
                ],
                'default',
                'value' => 1
            ],
            [
                [
                    'displayorder'
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
            'name' => Yii::t('config', 'Category Name'),
            'status' => Yii::t('config', 'Status'),
            'remark' => Yii::t('config', 'Remark'),
            'displayorder' => Yii::t('config', 'Displayorder'),
            'created_at' => Yii::t('config', 'Created At'),
            'updated_at' => Yii::t('config', 'Updated At'),
            'created_by' => Yii::t('config', 'Created By'),
            'updated_by' => Yii::t('config', 'Updated By')
        ];
    }
    
    public function getConfigs() {
        return $this->hasMany(ConfigTable::className(), ['catid'=>'id']);
    }
    
    public static function getDropDownList() {
        $cats = self::find()->select(['id','name'])->where(['status'=>GlobalConst::STATUS_ACTIVE])->asArray()->all();
        $res = [];
        foreach ($cats as $cat) {
            $res[$cat['id']]= $cat['name'];
        }
        return $res;
    }
}
