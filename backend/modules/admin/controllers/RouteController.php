<?php

namespace app\modules\admin\controllers;

use backend\modules\admin\components\ItemController;
use backend\modules\admin\models\AuthItem;
use yii;
use yii\httpclient\Client;
use yii\base\ErrorException;


class RouteController extends ItemController
{

    /**
     * The action selects the array route.
     * @return mixed
     */
    public function actionIndex()
    {
        $url = Yii::$app->controller->module->params['url'];
        $client = new Client();
        $response = $client->createRequest()->setMethod('get')
            ->setUrl($url)
            ->send();

        $leftArray = json_decode($response->content);

        $rightArray= AuthItem::find()->select('name')
            ->where(['type' => 3])
            ->column();

        /**
         * Delete has got item in $leftArray
         */
        foreach ($rightArray as $item) {
            if (($key = array_search($item, $leftArray)) !== FALSE) {
                unset($leftArray[$key]);
            }
        }

        return $this->render('index', [
            'leftArray' => $leftArray,
            'rightArray' => $rightArray,
        ]);
    }

    /**
     * The action adds route data into table auth_item.
     * @return mixed
     */
    public function actionAddRoute()
    {
        if (Yii::$app->request->post()) {

            $model = new AuthItem();
            $names = Yii::$app->request->post();
            if (!$model->writeRoute($names)) {
                Yii::error($model->getErrors(), 'route');
            }

        } else {
            Yii::error('Not post!', 'route');
        }

    }

    /**
     * The action deletes route data from table auth_item.
     * @return mixed
     */
    public function actionDeleteRoute()
    {
        if (Yii::$app->request->post()) {
            try {
                $names = Yii::$app->request->post();
                AuthItem::deleteAll(['in', 'name', $names['key']]);
            } catch (ErrorException $e) {
                Yii::error($e->getMessage(), 'route');
            }

        } else {
            Yii::error('Not post!', 'route');
        }
    }

}