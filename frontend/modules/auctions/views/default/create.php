<?php

use yii\helpers\Html;





/* @var $this yii\web\View */
/* @var $model \frontend\modules\auctions\models\AucData */
/* @var $hash string */

//$this->title = Yii::t('app', 'Create Auto Table');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auto Tables'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'hash' => $hash,
    ]) ?>

</div>
