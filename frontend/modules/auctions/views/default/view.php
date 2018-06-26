<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\auctions\models\AucData */



$this->registerCssFile('/css/auc_images.css');
$this->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css');
$this->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js');


$js = <<<js

var fotoramaDiv = $('#fotorama_auc').fotorama();
var fotorama = fotoramaDiv.data('fotorama');

$('#fotorama_auc').dblclick(function(){
    fotorama.requestFullScreen();
});
js;
$this->registerJs($js);


$this->title = $model->agent_phone;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auto Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<!--suppress JSUnusedLocalSymbols -->
<script>var auto_id = <?= $model->id ?>;</script>

<div class="auto-table-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Work with images'), ['/new-images-table/index', 'auc_id' => $model->id],
            ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div id="fotorama_auc" class="fotorama"
                 data-fit="contain"
                 data-width="100%"
                 data-minheight="250"
                 data-maxheight="350"
                 data-thumbheight="64"
                 data-allowfullscreen="true" data-nav="thumbs" data-auto="false">
                <?php
                $imgs = $model->getImages();
                foreach ($imgs as $img) {
//                        echo Html::a(Html::img($tiny_image), $items['url'][$key]);
                    echo Html::img($img);
                }
                ?>
            </div>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'agent_phone',
        ],
    ]) ?>


</div>