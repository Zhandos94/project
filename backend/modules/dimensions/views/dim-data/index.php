<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $lotTypeSearch \backend\modules\dimensions\models\LotDimensionsSearch */
/* @var $lotTypeProvider yii\data\ActiveDataProvider */
/* @var $dimensionSearch \backend\modules\dimensions\models\DimDataSearch */
/* @var $dimensionProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('dim', 'Dim Datas');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="dim-data-index">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('dim', 'Create Dim Data'), ['create'], ['class' => 'btn btn-success']) ?>

                <?= Html::a(Yii::t('dim', 'Relations of dimensions'), ['/dimensions/relations'], [
                        'class' => 'btn btn-primary'
                ]) ?>

                <?= Html::a(Yii::t('dim', 'Visibility of dimensions'), ['/dimensions/visibility-settings'], [
                    'class' => 'btn btn-primary btn-raised'
                ]) ?>
            </p>
            <?= \yii\bootstrap\Tabs::widget([
                'items' => [
                    ['label' => 'Lot types',
                        'content' => $this->render('_lot_types', [
//                            'searchModel' => $lotTypeSearch,
                            'dataProvider' => $lotTypeProvider,
                        ]),
//                        'active' => true
                    ],
                    [
                        'label' => 'Dimensions',
                        'content' => $this->render('_dimensions', [
                            'searchModel' => $dimensionSearch,
                            'dataProvider' => $dimensionProvider
                        ]),
                        'renderTabContent' => true
                    ]
                ]
            ]) ?>

        </div>
    </div>
</div>
