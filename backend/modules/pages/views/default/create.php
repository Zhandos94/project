<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesData */

$this->title = Yii::t('app', 'Create Aux Pages Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aux-pages-data-create">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
