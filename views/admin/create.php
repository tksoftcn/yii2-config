<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model tksoft\config\models\ConfigTable */

$this->title = Yii::t('config', 'Create Config Table');
$this->params['breadcrumbs'][] = ['label' => Yii::t('config', 'Config Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
