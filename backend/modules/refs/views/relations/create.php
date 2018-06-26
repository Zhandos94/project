<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefRelationsTable */
/* @var $relCols \backend\modules\refs\models\RefRelationsColumns[] */

$this->title = Yii::t('app', 'Create Ref Relations Table');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ref Relations Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-relations-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'relCols' => $relCols,
    ]) ?>

</div>
