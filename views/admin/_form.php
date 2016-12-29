<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use tksoft\config\models\CategoryTable;
use tksoft\config\models\GlobalConst;
use tksoft\config\models\ConfigTable;

/* @var $this yii\web\View */
/* @var $model tksoft\config\models\ConfigTable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-table-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'catid')->dropDownList(CategoryTable::getDropDownList(),GlobalConst::prompt()) ?>

    <?= $form->field($model, 'type')->dropDownList(ConfigTable::getFieldTypes(),GlobalConst::prompt()) ?>
    
    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isrequired')->radioList(GlobalConst::bool()) ?>

    <?= $form->field($model, 'min')->textInput() ?>

    <?= $form->field($model, 'max')->textInput() ?>

    <?= $form->field($model, 'rule')->dropDownList(ConfigTable::getExtraRules(), GlobalConst::prompt()) ?>

    <?= $form->field($model, 'remark')->textInput() ?>
    
    <?= $form->field($model, 'displayorder')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('config', 'Create') : Yii::t('config', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
