<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefDynamicTableName */
/* @var $dataModels \backend\modules\refs\models\RefDynamicTableData */

$this->title = Yii::t('app', 'Create Ref Dynamic Names');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ref Dynamic Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-dynamic-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataModels' => $dataModels,
    ]) ?>

</div>
