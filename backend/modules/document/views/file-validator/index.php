<?php
use yii\bootstrap\Nav;
?>
<div class="document-default-index">
    <div class="row">
        <div class="col-md-3">
            <?php
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills nav-stacked well well-sm',

                ],
                'encodeLabels' => false,
                'activateItems' => true,
                'items' => [
                    [
                        'label' =>  Yii::t('app', 'Document').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                        'url' => ['document/index'],
                    ],
                    [
                        'label' =>  Yii::t('app', 'Document category').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                        'url' => ['doc-category/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Document format').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                        'url' => ['doc-format/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Document category format').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                        'url' => ['doc-cat-format/index'],
                    ],
                ],
            ]);

            ?>
        </div>
    </div>
