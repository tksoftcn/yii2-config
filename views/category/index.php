<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use tksoft\config\models\GlobalConst;
/* @var $this yii\web\View */
/* @var $searchModel tksoft\config\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('config', 'Category Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-table-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('config', 'Create Category Table'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('config', 'Setting Page'), ['default/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('config', 'Admin Page'), ['admin/index'], ['class' => 'btn btn-purple']) ?>
    </p>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            //'id',
            'name',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return GlobalConst::statusHtml($model->status);
                },
                'format' => 'html',
            ],
            'remark',
            'displayorder',
            'created_at:datetime',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
