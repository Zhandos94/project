<?php

use backend\modules\refs\services\RefService;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefRelationsTable */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $relCols \backend\modules\refs\models\RefRelationsColumns[] */

$relService = new \backend\modules\refs\services\RelationService();
$parCols = $relService->getColumnList($model->parent_table_id);
$chCols = $relService->getColumnList($model->child_table_id);

$jsParCols = json_encode($parCols);
$jsChCols = json_encode($chCols);

$js = <<< JS
var parentCols = $jsParCols,
    childCols = $jsChCols;
$('#add-relation').on('click', function() {
    addRelation('RefRelationsColumns', parentCols, childCols);
});

$('#parent_table').on('change', function(){
    getColumns($(this).val());
    $('#relations').html('');
});

$('#child_table').on('change', function(){
    getColumns($(this).val(), true);
    $('#relations').html('');
});

function getColumns(refId, child){
    $.ajax({
        type:'get',
        url:'/refs/get/columns',
        data:{id:refId},
        success:function(response){
            response = JSON.parse(response);
            if(child){
                childCols = response;
            } else {
                parentCols = response;
            }
        }
    });
}
JS;

$this->registerJs($js);
$this->registerJsFile('/js/dynamic_form.js');
$relCount = count($relCols);
?>
<script>
    var i = <?= $relCount ?> +1;
</script>
<div class="ref-relations-table-form">
    <div class="panel">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">

                <div class="col-md-6">
                    <?= $form->field($model, 'parent_table_id')->dropDownList(RefService::getTables(), [
                        'prompt' => Yii::t('ref', 'Select parent reference table'),
                        'id' => 'parent_table',
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'child_table_id')->dropDownList(RefService::getTables(), [
                        'prompt' => Yii::t('ref', 'Select child reference table'),
                        'id' => 'child_table',
                    ]) ?>
                </div>

            </div>

            <div class="row">
                <div id="relations">
                    <?php if (!empty($relCols)) {
                        /* @var $relCol \backend\modules\refs\models\RefRelationsColumns */
                        foreach ($relCols as $key => $relCol) {
                            $num = $key + 1;
                            $parInputName = $relCol->formName() . '[' . $key . '][parent]';
                            $chInputName = $relCol->formName() . '[' . $key . '][child]';
                            $parLabel = Html::label("Parent Column {$num}", $parInputName, ['class' => 'control-label']);
                            $chLabel = Html::label("Child Column {$num}", $chInputName, ['class' => 'control-label']);
                            ?>
                            <div id="relation_div_<?= $num ?>">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <?= $parLabel ?>
                                        <?= Html::dropDownList($parInputName, $relCol->parent_column,
                                            $parCols, [
                                                'class' => 'form-control',
                                                'prompt' => Yii::t('ref', 'Select column of parent table')
                                            ]) ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <?= $chLabel ?>
                                        <?= Html::dropDownList($chInputName, $relCol->child_column,
                                            $chCols, [
                                                'class' => 'form-control',
                                                'prompt' => Yii::t('ref', 'Select column of child table')
                                            ]) ?>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger remove-btn"> -</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>


                </div>
            </div>

            <div class="row">
                <button type="button" class="btn btn-success" id="add-relation"> +</button>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
