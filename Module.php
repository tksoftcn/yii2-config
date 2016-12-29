<?php
namespace tksoft\config;

use Yii;
/**
 * config module definition class
 */
class Module extends \yii\base\Module
{

    const VERSION = '1.0';

    /**
     * @var array Model map
     */
    public $modelMap = [];

    /** @var array An array of administrator's usernames. */
    public $admins = [];
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'tksoft\config\controllers';

    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
