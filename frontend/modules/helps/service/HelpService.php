<?php
namespace frontend\modules\helps\service;

use Yii;
use yii\httpclient\Client;
use backend\modules\helps\models\HelpIntro;
use common\services\GetIntColumn;

class HelpService
{
    public static function responseForSave($model)
    {
        $url = self::getUrl() . 'default/create';
        $client = new Client();
        $data = [
            'HelpIntro' => array_merge((array) $model, $model->attributes),
            'hash' => self::generateHash()
        ];
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->setData($data)
            ->send();
        return $response;
    }

    public static function responseForUpdate($model)
    {
        $client = new Client();
        $id = HelpIntro::find()->where(['page_id' => $model->page_id, 'element_id' => $model->element_id])->one()->id;
        $url = self::getUrl() . 'default/update?id=' . $id;
        $data = [
            'HelpIntro' => array_merge((array) $model, $model->attributes),
            'hash' => self::generateHash()
        ];
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->setData($data)
            ->send();
        return $response;
    }

    public static function responseForElementData($page_id, $element_id)
    {
        $client = new Client();
        $url = self::getUrl() . 'default/get-element-id-data?page_id=' . $page_id . '&element_id=' . $element_id . '&curr_lang=' . Yii::$app->language;
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl($url)
            ->send();
        return $response;
    }

    private static function getUrl()
    {
        $s  = Yii::$app->controller->module->params;
        return Yii::$app->controller->module->params['help_url'];
    }

    /**
     * [generateHash description]
     * @return string
     */
    private static function generateHash()
    {
        $hash = (new GetIntColumn('hash'))->execute();
        return $hash;
    }
}
?>