<?php

namespace frontend\modules\auctions\components;

use frontend\modules\auctions\models\AucImagesTemp;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\auctions\models\AucImages;
use Yii;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: Adlet
 * Date: 02.09.2016
 * Time: 17:54
 */
trait ImagesTrait
{

    public $imageFiles;
    public $hash;

    public function getImages($folder = 'uploads')
    {
        $images = AucImages::find()->where(['auc_id' => $this->id, 'locked' => 0])
            ->limit(100)
            ->orderBy(['general' => SORT_DESC])
            ->all();
        $arr = [];
        if (!empty($images)) {
            /* @var $image AucImages */
            foreach ($images as $image) {
                $arr[] = $this->getPath($image->save_name, '/', $folder);
            }
        } else {
            //>> TODO remove! temporary version TOLK
            if (!empty($this->imgsavename /*&& $this->imgsavename !== ''*/)) {
                /* @noinspection PhpUndefinedFieldInspection */
                $arr[] = \Yii::$app->request->BaseUrl . '/uploads/auction/' . $this->subject_id . '/' . $this->imgsavename;
            } else {
                //<< remove later
                $arr[] = Yii::$app->params['no_foto'];  //TODO change to params?
            }
        }
        return $arr;
    }

    public function getPath($save_name, $slash = '/', $folder = 'uploads')
    {
        $path = $slash . $this->getDir($save_name, $folder);
        return $path . $save_name;
    }

    public function getDir($images, $folder = 'uploads')
    {
        if (!empty($images)) {
            //$formatter = \Yii::$app->formatter;
            //$path = $formatter->asDatetime($this->cr_date, 'yyyyMMdd') . '/';
            //$path = $formatter->asDatetime($this->lastupdate, 'yyyyMMdd') . '/'; //TODO refactor created_date
            $path = $this->getGroup() . '/';
            $path_img = $folder . '/' . substr($images, 0, 2) . '/' . substr($images, 2, 2) . '/';
            $url = 'i/' . $path . $path_img;
        } else {
            $url = Yii::$app->params['no_foto'];
        }
        return $url;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        /*if (($techInfo = AucTechInfo::findOne($this->id)) !== null) {
            return $techInfo->tech_group;
        } else {
            return 'Y' . date("y") . '-00';
        }*/
        return 'Y' . date("y") . '-' . date("m");
    }

    public function moveTempImg()
    {
        $main_exist = false;
        $temp_images = AucImagesTemp::find()->where(['hash' => $this->hash])->all();
        $main_temp = AucImagesTemp::find()->where(['hash' => $this->hash, 'general_img' => 1])->one();
        if ($main_temp !== null) {
            $main_exist = true;
        }
        /* @var AucImagesTemp $tmp_img */
        foreach ($temp_images as $key => $tmp_img) {
            $img = new AucImages();
            $img->name = $tmp_img->name;
            $img->save_name = $tmp_img->save_name;
            if (!$main_exist) {
                $img->general = $key == 0 ? 1 : 0;
            } else {
                $img->general = $tmp_img->general_img;
            }
            $img->auc_id = $this->id;
            if ($img->save()) {
                try {
                    if (!file_exists($this->getDir($img->save_name))) {
                        mkdir($this->getDir($img->save_name), 0775, true);
                    }
                    rename(self::getTempPath($this->hash, $tmp_img->save_name),
                        $this->getPath($img->save_name, null));
                } catch (ErrorException $e) {
                    Yii::info($e->getMessage(), 'auc_log');
                    throw $e;
                }
            } else {
                Yii::info($img->getErrors(), 'auc_log');
                return false;
            }
        }
        AucImagesTemp::deleteAll(['hash' => $this->hash]);
        return true;
    }

    public static function getTempPath($hash, $save_name = null)
    {
        return 'temp_storage/' . $hash . '/' . $save_name;
    }

    public static function getTempDir($hash)
    {
        return 'temp_storage/' . $hash . '/';
    }

    public static function getTempImgUrl($hash, $save_name)
    {
        return Url::home(true) . 'temp_storage/' . $hash . '/' . $save_name;
    }

    public static function generateHash()
    {
        do {
            $hash = Yii::$app->security->generateRandomString(10);
        } while (file_exists(self::getTempPath($hash)));
        mkdir(self::getTempPath($hash), 0775, true);
        return $hash;
    }

    /**
     * @param UploadedFile $file
     * @param string $hash
     * @return array
     */
    public function tempSave($file, $hash)
    {
        if ($file !== null) {
            $output = ['error' => 'file ' . $file->name . ' has error'];
            if (!self::hasError($file)) {
                $temp_img = new AucImagesTemp();
                $temp_img->name = $file->name;
                $temp_img->hash = $hash;
                $temp_img->save_name = self::generateSaveName($file);
                if ($temp_img->save()) {
                    if ($file->saveAs(self::getTempPath($hash, $temp_img->save_name))) {
                        $output = [
                            'initialPreview' => [
                                self::getTempImgUrl($hash, $temp_img->save_name),
                            ],
                            'initialPreviewConfig' => [
                                [
                                    'caption' => $file->name,
                                    'url' => 'delete-temp-img',
                                    'key' => $temp_img->save_name
                                ]
                            ],
                            'initialPreviewThumbTags' => [
                                ['{do-main}' => Html::a(Yii::t('app', 'do main'),
                                    ['temp-main', 'hash' => $hash, 'save_name' => $temp_img->save_name],
                                    ['class' => 'btn btn-xs btn-block btn-default'])]
                            ],

                        ];
                    }
                }
            }
        }else {
            Yii::info('get null file', 'auc_images_log');
            $output = ['error' => Yii::t('app', 'get error on save')];
        }
        return $output;
    }

    /**
     * @param $file UploadedFile
     * @return array
     */
    public function uploadImg($file)
    {
        if ($file !== null) {
            $output = ['error' => 'file ' . $file->name . ' has error'];
            if (!self::hasError($file)) {
                $img = new AucImages();
                $img->name = $file->name;
                $img->save_name = self::generateSaveName($file);
                $img->auc_id = $this->id;
                if ($img->save()) {
                    if (!file_exists($this->getDir($img->save_name))) {
                        mkdir($this->getDir($img->save_name), 0775, true);
                    }
                    if ($file->saveAs($this->getPath($img->save_name, null))) {
                        $output = [
                            'initialPreview' => [
                                $this->getPath($img->save_name),
                            ],
                            'initialPreviewConfig' => [
                                [
                                    'caption' => $file->name,
                                    'url' => Url::to(['ajax-delete', 'auc_id' => $this->id]),
                                    'key' => $img->save_name
                                ]
                            ],
                            'initialPreviewThumbTags' => [
                                ['{do-main}' => Html::a(Yii::t('app', 'do main'), ['do-main', 'auc_id' => $this->id,
                                    'save_name' => $img->save_name], ['class' => 'btn btn-xs btn-block btn-default'])]
                            ]
                        ];
                    }

                } else {
                    Yii::info($img->getErrors(), 'auc_images_log');
                }
            }
        } else {
            Yii::info('get null file', 'auc_images_log');
            $output = ['error' => Yii::t('app', 'get error on save')];
        }
        return $output;
    }

    /**
     * @param $file UploadedFile
     * @return string
     */
    public static function generateSaveName($file)
    {
        $save_name = Yii::$app->security->generateRandomString() . '.' . $file->extension;
        /* @var $count int count of models with same save_name */
        $count = AucImages::find()->where(['save_name' => $save_name])->count();
        while ($count > 0) {
            $save_name = Yii::$app->security->generateRandomString() . '.' . $file->extension;
            $count = AucImages::find()->where(['save_name' => $save_name])->count();
        }
        return $save_name;
    }

    /**
     * @param $file UploadedFile
     * @return boolean
     */
    public static function hasError($file)
    {
        $error = false;
        if ($file === null || $file->hasError) { //not have tempName
            $error = true;
        } else {
            $mime_type = mime_content_type($file->tempName);
            if (substr($mime_type, 0, 5) != 'image' || $file->size > self::IMG_MAX_SIZE) {
                $error = true;
            }
        }
        return $error;
    }

    public function deleteImg()
    {
        $response = json_encode([]);
        $save_name = Yii::$app->request->post('key');
        /* @var $image AucImages */
        $image = AucImages::find()->where(['auc_id' => $this->id, 'save_name' => $save_name])->one();
        if ($image !== null) {
            if ($image->general == 1) {
                /* @var $another_img AucImages */
                $another_img = AucImages::find()->where(['auc_id' => $this->id])->one();
                $another_img->general = 1;
                if (!$another_img->save()) {
                    Yii::info('can not save another general image, id=' . $another_img->id, 'auc_images_log');
                    return json_encode(['error' => Yii::t('app', 'Problem with file')]);
                }
            }
        } else {
            Yii::info('removing image model is not exist', 'auc_images_log');
            return $response;
        }
        if ($image->delete()) {
            if (file_exists($this->getPath($save_name, null))) {
                if (!unlink($this->getPath($save_name, null))) {
                    Yii::info('has not been deleted file, save name = ' . $save_name, 'auc_images_log');
                }
            } else {
                Yii::info('the deleted file didn\'t exist, save name = ' . $save_name, 'auc_images_log');
            }
        } else {
            Yii::info('image model has not been deleted, id=' . $save_name, 'auc_images_log');
        }
        return $response;
    }

}