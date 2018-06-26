<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\AucData */
/* @var $lotModel \frontend\models\Lot */
/* @var $lotAttrErr string */

$this->title = Yii::t('app', 'Create Auc Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auc Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auc-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lotModel' => $lotModel,
        'lotAttrErr' => $lotAttrErr,
    ]) ?>

</div>
