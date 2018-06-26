<?php
/**
 * Created by IntelliJ IDEA.
 * User: Adlet
 * Date: 17.06.2016
 * Time: 16:44
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $table_name string */
/* @var $prim_key_val string */
/* @var $prim_key string */
/* @var $columns string[] */

$this->title = Yii::t('app', 'Update {table_name}',['table_name' => $table_name]);
$this->params['breadcrumbs'][] = ['label' => $table_name, 'url' => ['index','table_name' => $table_name]];
$this->params['breadcrumbs'][] = ['label' => $prim_key_val, 'url' => ['view', 'table_name' => $table_name, 'prim_key' => $prim_key_val]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="default-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'columns' => $columns,
        'prim_key' => $prim_key,
        'create' => false,
    ]) ?>

</div>