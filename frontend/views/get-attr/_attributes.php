<?php
/**
 * Created by BADI.
 * DateTime: 02.12.2016 10:35
 */
use common\models\LotAttributeVal;
use common\services\dimensions\Get;
use frontend\services\dimensions\IsVisible;
use frontend\services\dimensions\JsService;
use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\helpers\Html;

/* @var $lotTypeId integer */
/* @var $this \yii\web\View */
/* @var $aucId integer */
/* @var $lotModel \common\interfaces\HasDimension */
/* @var $lotAttrErr string */


if (!isset($lotTypeId)) {
    $lotTypeId = $lotModel->getLotTypeId();
} else {
    $lotModel = new \frontend\models\Lot();
}
$aucId = $lotModel->getAucId();
$lotTypeCode = null;
$lotTypesModel = \common\models\refs\RefLotTypes::findOne($lotTypeId);
if ($lotTypesModel !== null) {
    $lotTypeCode = $lotTypesModel->code;
}
$get = new Get();

$lotDims = $get->lotDims($lotTypeId);
$jsService = new JsService($lotTypeId);
$numParams = $jsService->getNumericParams();
$stringParams = $jsService->getStringParams();
$dateParams = $jsService->getDateParams();
$relationParams = $jsService->getRelationsParams();

$postValues = $get->postValues();

$controlClass = 'form-control';
$reqClass = ' required-dim ';
$defaultDateClass = ' datetime-attr ';
$model = new LotAttributeVal();

$js = <<< JS
var numParams = $numParams,
    stringParams = $stringParams,
    dateParams = $dateParams,
    errors = $lotAttrErr,
    postValues = $postValues,
    relParams = $relationParams;


console.log(relParams);

relationListenInit(relParams);

$(errors).each(function(){
    addError(this.id, this.message);
});

$(postValues).each(function(){
    $('#'+this.id).val(this.val);
});

  var preValidateConstructor = function() {
     var requireValid = validateRequires(),
     stringValid = validateString(stringParams),
     dateValid = validateDate(dateParams),
     validate = requireValid && stringValid && dateValid,
     lotTypeId = $('#auction-colcat_id').val();
    if (validate == true) {
        var data = $('#dynamic_form input, #dynamic_form select').serialize() + '&lotTypeId=' + lotTypeId;
        ajaxValidation(data, 'auction-form');
    }
};
  
$('#dynamic_form input, #dynamic_form select').on('change', function () {
    $(this).siblings('p').html('');
});


function ajaxValidation(data, formName) {
    $.ajax({
        type: 'POST',
        url: '/get-attr/validate-attr-vals',
        data: data,
        success: function (response) {
            response = JSON.parse(response);
            if (response !== true) {
                $(response).each(function () {
                    addError(this.id, this.message);
                });
            } else {
                $('#' + formName).submit();
            }
        }
    });
}

initNum(numParams);

initString(stringParams);

JS;

$this->registerJs($js, \yii\web\View::POS_END);
$this->registerJsFile('/js/dimensions/baseValidate.js');
$this->registerJsFile('/js/dimensions/relationSupport.js');
?>

<style>
    .col-md-0{
        display: none;
    }
</style>
<div id="dynamic_form">
    <div id="<?= $lotTypeCode ?>_dynamic_form">
        <?php
        foreach ($lotDims as $row => $lotDim) {
            ?>
            <div class="row">
                <?php
                /* @var \backend\modules\dimensions\models\LotDimensions $q */
                foreach ($lotDim as $key => $q) {
                    $dimension = $q->dimension;
                    $dimCode = $dimension->code;
                    $dimName = Yii::t('dim', $dimension->name);
                    $placeholder = Yii::t('dim', $dimension->placeholder);
                    $inputName = $model->formName() . '[' . $dimCode . ']';
                    $inputId = 'lot-dim-' . $dimCode;
                    $dataTypeCode = $dimension->dataType->code;
                    $required = $dimension->is_required && $dimension->is_active;
                    $dateFormat = $dimension->with_time ? 'yyyy-mm-dd hh:ii' : 'yyyy-mm-dd';
                    $dateMinView = $dimension->with_time ? 0 : 3;
                    $value = $get->attrVal($lotModel, $dimension->id);
                    $label = $dimension->visible_label ? Html::label($dimName, $inputName,
                        ['class' => 'control-label']) : null;
                    $colCount = $q->col_count;
                    $visualDep = new \frontend\services\dimensions\IsVisualDependent($dimension->id);
                    $visParDimId = $visualDep->execute();
                    if($visParDimId !== false){
                        $visParDimVal = $get->attrVal($lotModel, $visParDimId);
                        $visService = new IsVisible($dimension->id, $visParDimId, $visParDimVal);
                        if($visService->execute() === true){
                            $colCount = 0;
                        }
                    }
                    if ($q->dimension->is_active) {
                        switch ($dataTypeCode) {
                            case 'checkbox':
                                ?>
                                <div class="col-md-<?= $colCount ?>">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <?= Html::checkbox($inputName,
                                                $value, ['label' => $dimName, 'id' => $inputId]) ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                break;

                            case 'string':
                            case 'numeric':

                                ?>
                                <div class="col-md-<?= $colCount ?>">
                                    <div class="form-group">
                                        <?= $label ?>
                                        <?= Html::textInput($inputName, $value,
                                            [
                                                'class' => $controlClass . ($required ? $reqClass : null),
                                                'id' => $inputId
                                            ]) ?>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <?php
                                break;
                            case 'datetime': ?>
                                <div class="col-md-<?= $colCount ?>">
                                    <div class="form-group">
                                        <?= $label ?>
                                        <?= \kartik\datetime\DateTimePicker::widget([
                                            'name' => $inputName,
                                            'id' => $inputId,
                                            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                            'value' => $value,
                                            'options' => [
                                                    'class' => $required ? $reqClass . $defaultDateClass
                                                : $defaultDateClass
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'minView' => $dateMinView,
                                                'format' => $dateFormat,
                                                'startDate' => $dimension->min_date,
                                                'endDate' => $dimension->max_date,
                                            ]
                                        ]) ?>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>

                                <?php
                                break;
                            case 'ref': ?>
                                <div class="col-md-<?= $colCount ?>">
                                    <div class="form-group">
                                        <?= $label ?>
                                        <?php
                                        $isDependent = new \frontend\services\dimensions\IsDependent($q->dim_id);
                                        $parentDimId = $isDependent->execute();
                                        if ($parentDimId === false) {
                                            $list = $get->ref($dimension);
                                        } else {
                                            $parentVal = $get->attrVal($lotModel, $parentDimId);
                                            $list = $get->dependentList($parentVal, $dimension, $parentDimId);
                                        }

                                        if (count($list) < LotAttributeVal::MAX_LIST_COUNT) {
                                            echo Html::dropDownList($inputName, $value, $list,
                                                [
                                                    'id' => $inputId,
                                                    'class' => $controlClass . ($required ? $reqClass : null),
                                                    'prompt' => $placeholder,
                                                    'data-prompt' => $placeholder,
                                                    'data-name' => $dimension->code,
                                                ]);
                                        } else {
                                            echo Select2::widget([
                                                'data' => $list,
                                                'name' => $inputName,
                                                'value' => $value,
                                                'options' => [
                                                    'placeholder' => $placeholder,
                                                    'id' => $inputId,
                                                    'class' => $required ? $reqClass : null,
                                                    'data-prompt' => $placeholder,
                                                    'data-name' => $dimension->code,
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                        }
                                        ?>

                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <?php
                                break;
                            case 'text': ?>
                                <div class="col-md-<?= $colCount ?>">
                                    <?= Yii::t('dim', $dimName); ?>
                                </div>
                                <?php
                        }
                    }

                }
                ?>
            </div>
            <?php
        }
        ?>

    </div>

</div>