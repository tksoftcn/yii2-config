<?php
namespace tksoft\config\models;

use Yii;
use yii\base\Model;

/**
 * Global const parameters class
 * 
 * @author tongke
 *
 */
class GlobalConst extends Model {
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    const BOOL_TRUE = 1;
    const BOOL_FALSE = 0;
    /**
     * page size
     * 
     * @param string $p
     * @return array
     */
    public static function pageSize($p = 'rows') {
        $p = ' '.Yii::t('config', $p);
        return [
            20=>'20'.$p,
            50=>'50'.$p,
            100=>'100'.$p,
            200=>'200'.$p,
            500=>'500'.$p,
            1000=>'1000'.$p,
            2000=>'2000'.$p,
        ];
    }
    
    /**
     * status options
     */
    public static function status() {
        return [
            self::STATUS_ACTIVE => Yii::t('config', 'Active'),
            self::STATUS_INACTIVE => Yii::t('config', 'Inactive'),
        ];
    }
    
    public static function statusName($t) {
        return isset(self::status()[$t]) ? self::status()[$t] : '';
    }
    
    public static function statusHtml ($t) {
        if ($t == 1)
            return '<span class="label label-success">'.Yii::t('config', 'Active').'</span>';
        return '<span class="label label-danger">'.Yii::t('config', 'Inactive').'</span>';
    }
    
    /**
     * yes or no
     */
    public static function bool() {
        return [
            self::BOOL_TRUE => Yii::t('config', 'Yes'),
            self::BOOL_FALSE => Yii::t('config', 'No'),
        ];
    }
    
    public static function boolName($t) {
        return isset(self::bool()[$t]) ? self::bool()[$t] : '';
    }
    
    public static function boolHtml ($t) {
        if ($t == 1)
            return '<span class="label label-success">'.Yii::t('config', 'Yes').'</span>';
        return '<span class="label label-danger">'.Yii::t('config', 'No').'</span>';
    }
    
    public static function prompt($pre = '--- ',$post = ' ---') {
        return ['prompt'=>$pre.Yii::t('config', 'Prompt').$post];
    }
}