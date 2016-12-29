<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\SettingTable;
use tksoft\config\models\ConfigTable;
use tksoft\config\models\GlobalConst;

$this->title = '全局参数';
$this->params['breadcrumbs'][] = [
    'label' => '系统管理',
    'url' => [
        '/backend/default/index'
    ]
];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-header">
	<h1>
		<?=$this->title ?> <small> <i
			class="ace-icon fa fa-angle-double-right"></i> 查看和管理系统运行的参数
		</small>
	</h1>
</div>
<?php
$form = ActiveForm::begin([
    'layout' => 'horizontal'
]);
?>

<?=$form->errorSummary($model,['header'=>'','footer'=>'','class'=>'alert alert-danger']); ?>
<style>
.error-summary ul li {
	list-style-type:none;
	display:inline;
	margin-left: 5px;
	font-size:14px;
}
</style>
<div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	    <?php
	    $showFirst = true;
    foreach ($model->cats as $catid => $catname) :
        ?>
		<li class="<?= ($showFirst) ? 'active':'' ?>"><a
			data-toggle="tab" href="#<?=$catid?>"
			aria-expanded="<?= ($showFirst) ? 'true':'false' ?>">
				<?=$catname?>
		</a></li>
		<?php $showFirst = false; ?>
        <?php endforeach; ?>
	</ul>

	<div class="tab-content">
	    <?php
	    $showFirst = true;
    foreach ($model->cats as $catid => $catname) :
        ?>	
		<div id="<?=$catid?>"
			class="tab-pane fade <?= ($showFirst) ? 'active in':'' ?>">
		
<?php
        if (isset($model->catSettings[$catid])) {
            foreach ($model->catSettings[$catid] as $key => $set) {
                $field = '';

                if ($set->type == ConfigTable::TYPE_DROPDOWNLIST) {
                    $field = $form->field($model, $model->_setPrefix . $set->id)->dropDownList($set->getSelectList(),GlobalConst::prompt());
                }
                
                if ($set->type == ConfigTable::TYPE_RADIO) {
                    $field = $form->field($model, $model->_setPrefix . $set->id)->inline(true)->radioList(GlobalConst::bool());
                }
                
                if ($set->type == ConfigTable::TYPE_CHECKBOX) {
                    $field = $form->field($model, $model->_setPrefix . $set->id)->checkBoxList($set->getSelectList());
                }
                
                if ($set->type == ConfigTable::TYPE_TEXT) {
                    $field = $form->field($model, $model->_setPrefix . $set->id);
                }
                
                if ($set->type == ConfigTable::TYPE_TEXTAREA) {
                    $field = $form->field($model, $model->_setPrefix . $set->id)->textarea([
                        'rows' => 4
                    ]);
                }
                
                if ($set->type == ConfigTable::TYPE_NUMBER) {
                    $field = $form->field($model, $model->_setPrefix . $set->id);
                }
                
                //$field->hint($set->remark);
                echo $field;
            }
            ?>
            <div class="form-group">
				<div class="col-lg-offset-3 col-lg-4">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-block btn-success'])?>
                </div>
			</div>
        <?php
        }
        ?>
		</div>
		<?php $showFirst = false; ?>
		<?php endforeach; ?>
	</div>
</div>






<?php ActiveForm::end(); ?>