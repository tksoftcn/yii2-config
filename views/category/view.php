<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use tksoft\config\models\GlobalConst;

/* @var $this yii\web\View */
/* @var $model tksoft\config\models\CategoryTable */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('config', 'Category Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-table-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('config', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('config', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('config', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'status',
                'value' => GlobalConst::statusHtml($model->status),
                'format' => 'html'
            ],
            'remark',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
