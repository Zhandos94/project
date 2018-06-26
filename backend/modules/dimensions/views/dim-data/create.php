<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimData */

$this->title = Yii::t('dim', 'Create Dim Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dim-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
