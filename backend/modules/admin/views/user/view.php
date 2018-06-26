<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'logUserStatus.name',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
