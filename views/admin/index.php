<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use tksoft\config\models\GlobalConst;
/* @var $this yii\web\View */
/* @var $searchModel tksoft\config\models\ConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('config', 'Config Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-table-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('config', 'Create Config Table'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('config', 'Setting Page'), ['default/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('config', 'Category Page'), ['category/index'], ['class' => 'btn btn-purple']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'name',
            'key',
            //'value:ntext',
            [
                'attribute' => 'catid',
                'value' => function ($model) {
                    return $model->category->name;
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return Yii::t('config', $model->type);
                }
            ],
            [
                'attribute' => 'isrequired',
                'value' => function ($model) {
                    return GlobalConst::boolHtml($model->isrequired);
                },
                'format' => 'html'
            ],
            // 'min',
            // 'max',
            // 'data:ntext',
            // 'rule',
            'displayorder',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
