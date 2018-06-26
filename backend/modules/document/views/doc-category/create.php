<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docCategory */

$this->title = Yii::t('app', 'Create Doc Category');
$this->params['breadcrumbs'][] = ['label' => 'Doc Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
