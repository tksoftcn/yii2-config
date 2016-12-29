<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model tksoft\config\models\ConfigTable */

$this->title = Yii::t('config', 'Update {modelClass}: ', [
    'modelClass' => 'Config Table',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('config', 'Config Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('config', 'Update');
?>
<div class="config-table-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
