<?php
namespace tksoft\config\controllers;

use Yii;
use yii\web\Controller;
use tksoft\config\models\ConfigForm;
use tksoft\config\models\ConfigTable;

/**
 * Default controller
 * 
 * @author tongke
 *
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * 
     * @return string
     */
    public function actionIndex()
    {
        //ConfigTable::buildCache();
        $c = Yii::$app->cache->get('tksoft.config');
        print_r($c);

        $model = new ConfigForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->settings as $key=>$setting) {
                $setting->value = $model->{$model->_setPrefix.$setting->id};
                
                $t = $setting->save();
                if (!$t) {
                    Yii::$app->session->setFlash('danger',Yii::t('config', 'Configuration save failed'));
                    Yii::warning($setting->getErrors('value'),'debug3');
                }
            }
            Yii::$app->session->setFlash('success', Yii::t('config', 'Configuration saved successfully'));
            return $this->refresh();
        }
        
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
