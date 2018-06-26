<?php

/**
 * Created by IntelliJ IDEA.
 * User: Adlet
 * Date: 14.06.2016
 * Time: 16:07
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $columns string[] */
/* @var $table_name string */
/* @var $prim_key string */
$this->title = Yii::t('app', 'Create {table_name}', ['table_name' => $table_name]);
$this->params['breadcrumbs'][] = ['label' => $table_name, 'url' => ['index', 'table_name' => $table_name]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msg-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'columns' => $columns,
        'prim_key' => $prim_key,
        'create' => true
    ]) ?>

</div>
