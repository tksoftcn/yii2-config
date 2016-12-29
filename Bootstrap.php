<?php
namespace tksoft\config;

use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;
use yii\i18n\PhpMessageSource;

/**
 * Bootstrap for config component and module
 *
 * @author tongke
 *        
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * @var array Model's map
     */
    private $_modelMap = [
        'ConfigTable' => 'tksoft\config\models\ConfigTable',
        'ConfigSearch' => 'tksoft\config\models\ConfigSearch',
        'ConfigForm' => 'tksoft\config\models\ConfigForm',
        'CategoryTable' => 'tksoft\config\models\CategoryTable',
        'CategorySearch' => 'tksoft\config\models\CategorySearch'
    ];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        /**
         * @var Module $module
         * @var \yii\db\ActiveRecord $modelName
         */
        if ($app->hasModule('config') && ($module = $app->getModule('config')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                $class = "tksoft\\config\\models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }
            
            if (! isset($app->get('i18n')->translations['config*'])) {
                $app->get('i18n')->translations['config*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
        }
    }
}
