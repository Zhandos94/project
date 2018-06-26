<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use backend\modules\document\models\DocCategory;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="document-form">

    <?php $form = ActiveForm::begin(
       );
    ?>

    <?=  $form->field($model, 'name')->textInput(['maxlength' => true])
    ?>

    <?php if ($model->isNewRecord) {
        echo $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(DocCategory::getCategory(), 'id', 'name'),
                ['class' => 'form-control', 'prompt' => YII::t('app', 'Select category')]);
    }
    ?>

    <?php if ($model->isNewRecord) {
        echo $form->field($model, 'file')->widget(FileInput::classname(), [
    //        'options' => ['accept' => $model->getAllFormatName()],
            'pluginOptions' => ['showUpload' => false,
            'showRemove' => false,
            'dropZoneEnabled' => false,],]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<< JS
window.onload = function(){
    $('#document-cat_id').on('change', function(e) {
        e.preventDefault();
        var val = $(this).val()
         // console.log(val);
         
        // document.cookie = 'category'+val;      
        // console.log( document.cookie);

        
        // $.ajax({
        //         url: 'write',
        //         type: 'post',
        //         data: {val:val}, 
        //         success: function (data) {
        //             console.log(data)
        //         }
        //    });
    });
    

}
JS;
$this->registerJs($js);
?>