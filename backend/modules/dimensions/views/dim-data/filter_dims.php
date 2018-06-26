<?php
/**
 * Created by BADI.
 * DateTime: 20.12.2016 18:00
 */
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $lotTypeId integer */

$this->title = Yii::t('dim', 'Dim Datas');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="dim-data-filter_dims">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_dimensions', [
        'dataProvider' => $dataProvider,
        'lotTypeId' => $lotTypeId
    ]) ?>

</div>
