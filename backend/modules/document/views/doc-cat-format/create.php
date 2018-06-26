<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docCatFormat */

$this->title = Yii::t('app', 'Create Doc Cat Format');
$this->params['breadcrumbs'][] = ['label' => 'Doc Cat Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-cat-format-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
