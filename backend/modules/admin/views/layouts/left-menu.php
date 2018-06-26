<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Admin', 'url' => ['/myadmin']],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
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
                            'label' =>  Yii::t('app', 'User').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                            'url' => ['user/index'],
                        ],
                        [
                            'label' =>  Yii::t('app', 'User Log').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                            'url' => ['log-user/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Privilege').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                            'url' => ['privilege/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Grand Access').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                            'url' => ['access/index'],
                        ],
                        [
                            'label' => Yii::t('app', 'Route').'<span class="glyphicon glyphicon-chevron-right pull-right">',
                            'url' => ['route/index'],
                        ],
//                        [
//                            'label' => Yii::t('app', 'Rule').'<span class="glyphicon glyphicon-chevron-right pull-right">',
//                            'url' => ['rule/index'],
//                        ],
                    ],
                ]);

                ?>
            </div>
            <div class="col-md-9">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
