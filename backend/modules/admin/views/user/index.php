<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use backend\modules\admin\models\LogUser;
use backend\modules\admin\models\UserSearch;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'username',
                'value' => function ($model) {
                    return Html::a($model->username, ['/myadmin/access/view',
                        'id' => $model->id,]
                       );
                },
            ],
             'email:email',
            [
                'attribute' => 'status',
                'value' => 'logUserStatus.name',
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    ArrayHelper::map(UserSearch::getUserStatusName(), 'status', 'name'),
                    ['class' => 'form-control',
                        'prompt' => 'Select status']),

            ],
             'created_at:date',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->status == 10 ? Yii::t('app', 'Block') :
                        Yii::t('app', 'Unblock'), ['/myadmin/log-user/change',
                        'id' => $model->id,],
                        [
                            'class'=>'btn btn-warning show_modal'
                        ]);
                },
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>


<?php Modal::begin([
    'options'=>['id'=>'addMyModal'],
    'header' => Yii::t('app', 'Block or Unblock user')
]); ?>
<?php
$user_status = new LogUser();

$form = ActiveForm::begin([
    'enableClientValidation' => true,
]); ?>

    <?= $form->field($user_status, 'reason')->textarea(['rows' => 5, 'cols' => 5])->label('Reason') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn btn-primary sub', 'id' => 'sub']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php
$js = <<< JS
window.onload = function(){
    var url_j;
    $( ".show_modal" ).click(function(e) {
        e.preventDefault();
        $('#addMyModal').modal('show');
        url_j = $(this).attr('href');
    });
    
    $( ".close" ).click(function() {
       $("form").trigger("reset");
    });
    
    $('#addMyModal').submit( function(e) {
        e.preventDefault();
        $('#sub').prop("disabled", true);
        var fData = $('form').serialize(); 
        $.ajax({
            url: url_j,
            type: 'post',
            data: fData,

            success: function () {
                $('#addMyModal').modal('hide');
            }
        });
    });
}
JS;
$this->registerJs($js);
?>