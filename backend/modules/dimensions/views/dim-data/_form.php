<?php

use common\services\dimensions\Get;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimData */
/* @var $form yii\bootstrap\ActiveForm */

$get = new Get();
$genService = new \backend\modules\dimensions\services\DimGenService();

$js = <<< js

showElem($('#dimdata-type_id').val());

displayCreateElems();

$('#dimdata-type_id').on('change', function(){
    showElem($(this).val());
    clearInputs();
});

$('#dimdata-codeid').on('change', function(){
    displayCreateElems();
});

$('#dimdata-ref_id').on('change', function() {
    var val = $(this).val();
    displayRefsBlock(val);
});

$('#add-label').on('click', function() {
    addLabel('RefDynamicTableData');
});

$('#dynamic-ref-btn').on('click', function(){
    $('#dimdata-ref_id').val(-1).trigger('change');
});

$('#dynamic-ref-submit').on('click', function(){
    dropdownService();
});


var j = 1;
js;

$this->registerJs($js);
$this->registerJsFile('/js/dimensions/cr_attributes.js');
$this->registerJsFile('/js/dynamic_form.js');
?>

<div class="dim-data-form">
    <div class="panel">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'lotType')->dropDownList($get->lotTypesList(),
                [
                    'prompt' => Yii::t('dim', 'Select type of lot'),
                    'id' => 'auction-colcat_id'
                ]) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'codeId')->dropDownList($get->dimCodesList(),
                        ['prompt' => Yii::t('dim', 'Select existing code or create new dimension')]) ?>
                </div>
                <div class="col-md-6 dim-creating">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <?= $form->field($model, 'visible_label')->checkbox() ?>

            <div class="dim-creating">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'is_active')->checkbox() ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'is_required')->checkbox() ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <?= $form->field($model, 'type_id')->dropDownList($get->dimDataTypesList(),
                            ['prompt' => Yii::t('dim', 'Select dimension data type')]) ?>
                    </div>
                    <div class="col-md-5">
                        <div id="additional-2" class="additional-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'max_length')->textInput() ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'min_length')->textInput() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="additional-4" class="additional-block">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'min_date')->widget(\kartik\datetime\DateTimePicker::className(), [
                            'options' => ['placeholder' => Yii::t('dim', 'Select min date for attribute')],
                            'pluginOptions' => [
                                'autoclose' => true,
                            ]
                        ]); ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'max_date')->widget(\kartik\datetime\DateTimePicker::className(), [
                            'options' => ['placeholder' => Yii::t('dim', 'Select max date for attribute')],
                            'pluginOptions' => [
                                'autoclose' => true,
                            ]
                        ]); ?>
                    </div>
                </div>
                <?= $form->field($model, 'with_time')->checkbox() ?>
            </div>
            <div id="additional-3" class="additional-block">

                <?= $form->field($model, 'min_val')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'max_val')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'negative_allow')->checkbox() ?>

                <?= $form->field($model, 'decimal_sym_num')->textInput() ?>

            </div>

            <div id="additional-5" class="additional-block">
                <div class="row">
                    <div class="col-md-10">
                        <?= $form->field($model, 'ref_id')->dropDownList($get->refsList(), [
                            'prompt' => Yii::t('dim', 'Select existing ref or create new'),
                            'id' => 'dimdata-ref_id',
                        ]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span>', '#',
                            ['class' => 'btn btn-success', 'id' => 'dynamic-ref-btn',
                                'data-toggle' => 'modal', 'data-target' => '#dynamic-ref-add']) ?>
                    </div>
                </div>
                <div id="dynamic-ref-error">

                </div>
                <div id="dynamic-ref">
                    <?= $form->field($model, 'ref_group_id')->dropDownList($get->dynamicList(),
                        ['prompt' => Yii::t('dim', 'Select Group of Dynamic Reference')]) ?>
                </div>

                <?= $form->field($model, 'sort_by')->textInput() ?>

                <?= $form->field($model, 'placeholder')->textInput(['maxlength' => true]) ?>

            </div>

            <?= $form->field($model, 'group_id')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('dim', 'Create') : Yii::t('dim', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

<?php Modal::begin([
    'id' => 'dynamic-ref-add',
    'header' => Yii::t('ref', 'Add dynamic reference'),
    'size' => 'modal-lg'
]) ?>
<script>
    var j = 1;
</script>
<div class="modal-body">
    <?php $model = new \backend\modules\refs\models\RefDynamicTableName(); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-ref-form',
        'options' => ['class' => 'form-horizontal'],
        'action' => ['/refs/dynamic/create-modal']
    ]) ?>
    <div class="row">
        <?= $form->field($model, 'disabled')->checkbox() ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="row">
        <div id="labels">

        </div>
    </div>
    <div class="row">
        <button type="button" class="btn btn-success" id="add-label"> +</button>
    </div>
</div>
<div class='modal-footer'>
    <?= Html::button(Yii::t('dim', 'Modal window cancel'), ['class' => 'btn btn-danger', 'data-dismiss' => 'modal']); ?>
    <?= Html::button(Yii::t('dim', 'Create dunamic reference'), ['class' => 'btn btn-success', 'id' => 'dynamic-ref-submit']) ?>
</div>
<?php ActiveForm::end() ?>
<?php Modal::end(); ?>
