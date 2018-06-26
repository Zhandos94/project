<?php
/**
 * Created by IntelliJ IDEA.
 * User: Adlet
 * Date: 14.06.2016
 * Time: 16:14
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $columns string[] */
/* @var $create boolean */

$form = ActiveForm::begin();

?>
<div class="refs-default-form">
    <div class="panel">
        <div class="panel-body">
            <?php
            foreach ($columns as $column) {
                if ($column != 'disabled') {
                    echo $form->field($model, $column)->textInput();
                } else {
                    echo $form->field($model, $column)->checkbox();
                }
            }
            ?>
            <div class="form-group">
                <?= Html::submitButton($create ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                    ['class' => $create ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


