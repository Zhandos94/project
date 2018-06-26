<?php
/**
 * Created by PhpStorm.
 * User: mrdos
 * Date: 17.01.2017
 * Time: 15:08
 */

namespace app\modules\admin\controllers;

use Yii;
use backend\modules\admin\models\User;
use backend\modules\admin\models\UserSearch;
use backend\modules\admin\models\AuthAssignment;
use backend\modules\admin\components\ItemController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\ErrorException;

class AccessController extends ItemController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $params = Yii::$app->params['paramExclude'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'leftMass' => AuthAssignment::getArrayLeft($id, $params),
            'rightMass' => AuthAssignment::getArrayRight($id),
        ]);
    }

    /**
     * The action adds access data into table auth_assignment.
     * @param string $id
     * @return mixed
     */
    public function actionAuthAssignmentAdd($id)
    {
        if (Yii::$app->request->post()) {
            $item_child = new AuthAssignment();
            $item_name = Yii::$app->request->post();


            if (!$item_child->writeAuthAssignment(trim($id), $item_name)) {
                Yii::error($item_child->getErrors(), 'auth_assignment');
            }
        } else {
            Yii::error('Not post!', 'auth_assignment');
            return json_encode('not pos');
        }
    }

    /**
     * The action deletes access data from table auth_assignment.
     * @return mixed
     */
    public function actionAuthAssignmentDelete()
    {
        if (Yii::$app->request->post()) {
            try {
                $names = Yii::$app->request->post();

                $array = [];
                foreach ($names as $key => $name) {
                    foreach ($name as $item) {
                        $array[] = $item;
                    }
                }
                AuthAssignment::deleteAll(['in', 'item_name', $array]);
            } catch (ErrorException $e) {
                Yii::error($e->getMessage(), 'route');
            }
        } else {
            Yii::error('Not post!', 'route');
        }
    }
}