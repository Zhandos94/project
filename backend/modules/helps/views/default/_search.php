<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\helps\models\HelpIntroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="help-intro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row fields-helps-search">

        <?= $form->field($model, 'is_main', ['options' => ['class' => 'col-md-6']])->dropDownList($model::is_main(), [
            'prompt' => Yii::t('app', 'Select main for filter')
        ]) ?>

        <?= $form->field($model, 'is_only', ['options' => ['class' => 'col-md-6']])->dropDownList($model::is_only(), [
            'prompt' => Yii::t('app', 'Select only for filter')
        ]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Reset'), 'index', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
