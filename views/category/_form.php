<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use tksoft\config\models\GlobalConst;

/* @var $this yii\web\View */
/* @var $model tksoft\config\models\CategoryTable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-table-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(GlobalConst::status()) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'displayorder')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('config', 'Create') : Yii::t('config', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
