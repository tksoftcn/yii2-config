<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model tksoft\config\models\ConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-table-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'catid') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'isrequired') ?>

    <?php // echo $form->field($model, 'min') ?>

    <?php // echo $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'rule') ?>

    <?php // echo $form->field($model, 'displayorder') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('config', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('config', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
