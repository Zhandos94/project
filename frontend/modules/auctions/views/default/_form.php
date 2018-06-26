<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model \frontend\modules\auctions\models\AucData */
/* @var $form yii\widgets\ActiveForm */
/* @var $hash string */

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $this->render('_images',[
    'model' => $model,
    'form' => $form,
    'hash' => isset($hash) ? $hash : null,
]) ?>
<?= $form->field($model, 'agent_phone')->textInput() ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>





