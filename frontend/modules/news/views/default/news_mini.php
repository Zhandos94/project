<?php
/**
 * User: BADI
 * DateTime: 19.09.2016 18:58
 */

use yii\helpers\Url;

/* @var $this yii\web\View */

$formatter = Yii::$app->formatter;

$js = <<<JS
    getContent(url);
JS;
$this->registerJs($js);
$this->registerJsFile('/js/request_content.js');
?>
<!--suppress JSUnusedLocalSymbols -->
<script>
    var url = '<?=Yii::$app->getModule('news')->params['news_url']?>default/news-mini?site=<?= Url::home(true) ?>news/';
</script>
<div class="auc-news-data-single-news">
    <div id="response-content">

    </div>
</div>


