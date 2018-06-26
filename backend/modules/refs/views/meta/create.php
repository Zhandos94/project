<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\MetaTable */

$this->title = Yii::t('app', 'Create Meta Table');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
