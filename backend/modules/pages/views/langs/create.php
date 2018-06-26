<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesLangs */
/* @var $id integer */

$this->title = Yii::t('app', 'Create Aux Pages Langs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['/pages/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Langs'), 'url' => ['index', 'id' => $id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aux-pages-langs-create">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
