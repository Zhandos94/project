<?php
/**
 * Created by IntelliJ IDEA.
 * User: Adlet
 * Date: 20.06.2016
 * Time: 11:17
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $prim_key string */
/* @var $table_name string */
/* @var $columns string[] */

$this->title = $prim_key;
$this->params['breadcrumbs'][] = ['label' => $table_name,
    'url' => ['index', 'table_name' => $table_name]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="default-view">
    <div class="panel">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'table_name' => $table_name, 'prim_key' => $prim_key],
                    ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'table_name' => $table_name, 'prim_key' => $prim_key],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $columns

            ]) ?>
        </div>
    </div>
</div>
