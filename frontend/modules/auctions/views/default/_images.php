<?php
/**
 * Created by PhpStorm.
 * User: Adlet
 * Date: 05.09.2016
 * Time: 16:18
 */

use frontend\modules\auctions\models\AucImages;
use frontend\modules\auctions\models\AucImagesTemp;
use yii\helpers\Html;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\auctions\models\AucData */
/* @var $form yii\widgets\ActiveForm */
/* @var $hash string */

?>
<?php Pjax::begin(['enablePushState' => false]);

$js = <<< 'JS'
$('#auc-images-input').on('fileimagesloaded', function(event) {
    $(this).fileinput('upload');
});
JS;
$this->registerJs($js);
?>

<?php if (!empty($error)) {
    echo Html::tag('div', $error, ['class' => 'alert alert-danger']);
}
$preview = [];
$thumb_tags = [];
$preview_config = [];
$hash_data = null;
if ($model->isNewRecord) {
    $temp_images = AucImagesTemp::find()->where(['hash' => $hash])->all();
    /* @var $temp_images AucImagesTemp[] */
    for ($i = 0; $i < count($temp_images); $i++) {
        if ($temp_images[$i]->general_img == 1) {
            $frame_class = 'do-main';
            $main_button = Html::tag('div', Yii::t('app', 'Main'), ['class' => 'btn btn-xs btn-primary btn-block',
                'disabled' => true]);
        } else {
            $frame_class = '';
            $main_button = Html::a(Yii::t('app', 'do main'), ['temp-main', 'hash' => $hash,
                'save_name' => $temp_images[$i]->save_name], ['class' => 'btn btn-xs btn-block btn-default']);
        }
        $preview[$i] = $model::getTempImgUrl($hash, $temp_images[$i]->save_name);
        $preview_config[$i] = [
            'url' => 'delete-temp-img',
            'caption' => $temp_images[$i]->name,
            'key' => $temp_images[$i]->save_name,
            'frameAttr' => [
                'class' => 'file-preview-frame file-preview-initial ' . $frame_class
            ]
        ];
        $thumb_tags[$i] = ['{do-main}' => $main_button,];

    }
    $hash_data = $hash;
    $upload_url = 'temp-save';
    echo $form->field($model, 'hash')->hiddenInput(['value' => $hash])->label(false);
} else {
    $images = AucImages::find()->where(['auc_id' => $model->id])->all();
    /* @var $images AucImages[] */
    for ($i = 0; $i < count($images); $i++) {
        if($images[$i]->general==1){
            $frame_class = 'do-main';
            $main_button = Html::tag('div', Yii::t('app', 'Main'),
                ['class' => 'btn btn-xs btn-primary btn-block', 'disabled' => true]);
        } else {
            $main_button = Html::a(Yii::t('app', 'do main'), ['do-main', 'auc_id' => $model->id,
                'save_name' => $images[$i]->save_name], ['class' => 'btn btn-xs btn-block btn-default']);
            $frame_class = '';
        }
        $preview[$i] = $model->getPath($images[$i]->save_name);
        $preview_config[$i] = [
            'url' => \yii\helpers\Url::to(['ajax-delete', 'auc_id' => $model->id]),
            'caption' => $images[$i]->name,
            'key' => $images[$i]->save_name,
            'frameAttr' => [
                'class' => 'file-preview-frame file-preview-initial ' . $frame_class
            ]
        ];
        $thumb_tags[$i] = ['{do-main}' => $main_button,];
    }
    $upload_url = Url::to(['ajax-update-img', 'auc_id' => $model->id]);
}

?>
<!--suppress CssUnusedSymbol -->
<style>
    .do-main{
        background-color: rgba(82, 199, 223, 0.4);
    }
</style>
<?= $form->field($model, 'imageFiles')->widget(FileInput::className(), [
    'options' => [
        'id' => 'auc-images-input',
        'accept' => 'image/*',
        'multiple' => true
    ],
    'pluginOptions' => [
        'previewSettings' => [
            'image' => [
                'width' => '120px',
                'height' => '120px',
            ]
        ],
        'previewZoomSettings' => [
            'image' => [
                'width' => 'auto',
                'height' => '100%'
            ]
        ],
        'initialPreview' => $preview,
        'initialPreviewConfig' => $preview_config,
        'maxFileSize' => 8000,
        'dropZoneEnabled' => false,
        'showClose' => false,
        'uploadAsync' => true,
        'showRemove' => false,
        'overwriteInitial' => false,
        'initialPreviewAsData' => true,
        'showUpload' => false,
        'uploadUrl' => $upload_url,
        'initialPreviewThumbTags' => $thumb_tags,
        'uploadExtraData' => [
            'hash' => $hash_data,
        ],
        'deleteExtraData' => [
            'hash' => $hash_data,
        ],
        'layoutTemplates' => [
            'footer' => '<div class="file-thumbnail-footer">' .
                '    <div class="file-caption-name">{caption}</div>' .
                '    {do-main}' .
                '    {actions}' .
                '</div>',
        ]
    ]]); ?>
<?php Pjax::end() ?>
