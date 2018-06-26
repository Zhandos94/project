<?php

/**
 * Created by PhpStorm.
 * User: mrdos
 * Date: 26.01.2017
 * Time: 16:41
 */

namespace backend\modules\admin\components;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ItemController extends  Controller
{
    /**
     * @inheritdoc
     */
    public $id;

    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'cons'],
                    ],
                ],
            ],
        ];
    }
}