<?php

namespace frontend\modules\auctions\components;
/**
 * Created by PhpStorm.
 * User: Adlet
 * Date: 02.09.2016
 * Time: 17:13
 */
interface WithImagesInterface
{
    const IMG_MAX_SIZE = 10000000000;
    const STATUS_NEW = 8;
    const STATUS_NOT_LOCKED = 7;

    public function getImages($folder = 'uploads');

    public function getPath($save_name, $slash = '/', $folder = 'uploads');

    public function getDir($save_name, $folder = 'uploads');

    public static function generateHash();

    public function tempSave($file, $hash);

    public function deleteImg();

    public static function hasError($file);

    public static function generateSaveName($file);

    public function uploadImg($file);

    public static function getTempImgUrl($hash, $save_name);

    public static function getTempDir($hash);

    public static function getTempPath($hash, $save_name = null);

    public function moveTempImg();

    public function getGroup();
}