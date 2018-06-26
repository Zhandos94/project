<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefDynamicTableName */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $dataModels \backend\modules\refs\models\RefDynamicTableData[] */

$js = <<< JS

$('#add-label').on('click', function() {
    addLabel('RefDynamicTableData');
});
JS;

$this->registerJs($js);
$this->registerJsFile('/js/dynamic_form.js');
$dataCount = count($dataModels)
?>

<script>
    var j = <?= $dataCount ?> +1;
</script>
<div class="ref-dynamic-names-form">
    <div class="panel">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'disabled')->checkbox() ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <?php if (!empty($dataModels)) {
                    /* @var $dataModel \backend\modules\refs\models\RefDynamicTableData */
                    foreach ($dataModels as $key => $dataModel) {
                        $num = $key + 1;
                        $inputName = $dataModel->formName() . '[' . $key . ']';
                        $label = Html::label("Label {$num}", $inputName, ['class' => 'control-label']);
                        ?>
                        <div id="label-div-<?= $num ?>">
                            <div class="col-md-5">
                                <?= $label ?>
                                <?= Html::input('text', $inputName,
                                    $dataModel->name, ['class' => 'form-control']) . '<br>'; ?>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-btn" onclick="removeElem()"> -</button>
                            </div>
                        </div>
                        <?php
                    }
                } ?>

                <div id="labels">

                </div>
            </div>
            <div class="row">
                <button type="button" class="btn btn-success" id="add-label"> +</button>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
