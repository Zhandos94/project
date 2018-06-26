<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimRelations */

$this->title = Yii::t('dim', 'Create Dim Relations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dim-relations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
