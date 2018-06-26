<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docFormat */

$this->title = Yii::t('app', 'Create Doc Format');
$this->params['breadcrumbs'][] = ['label' => 'Doc Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-format-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
