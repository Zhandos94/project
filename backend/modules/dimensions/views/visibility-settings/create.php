<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimVisibilitySettings */

$this->title = Yii::t('dim', 'Create Dim Visibility Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Visibility Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dim-visibility-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
