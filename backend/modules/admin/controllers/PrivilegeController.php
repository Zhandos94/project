<?php

namespace app\modules\admin\controllers;

use Yii;
use backend\modules\admin\models\AuthItem;
use backend\modules\admin\models\AuthItemSearch;
use backend\modules\admin\models\AuthItemChild;
use backend\modules\admin\components\ItemController;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\base\ErrorException;
/**
 * PermissionController implements the CRUD actions for AuthItem model.
 */
class PrivilegeController extends ItemController
{

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $params = Yii::$app->params['paramExclude'];

        return $this->render('view', [
            'model' => $this->findModel($id),
            'leftArray' => AuthItem::getArrayLeft($id, $params),
            'rightArray' => AuthItem::getArrayRight($id),
        ]);
    }


    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Lists roles from AuthItem models.
     * @param string $id
     * @return mixed
     */
    public function actionShowRole($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::getListRole(trim($id)),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('listrole', ['dataProvider' => $dataProvider]);
    }

    /**
     * The action adds data into table auth_item_child.
     * @param string $id
     * @return mixed
     */
    public function actionItemChild($id)
    {
        if (Yii::$app->request->post()) {

            $item_child = new AuthItemChild();
            $children = Yii::$app->request->post();

            if (!$item_child->writeItemChild(trim($id), $children)) {
                Yii::error($item_child->getErrors(), 'auth_item');
            }
        } else {
            Yii::error('Not post', 'auth_item');
        }
    }


    /**
     * The action deletes data from table auth_item_child.
     * @param string $id
     * @return mixed
     */
    public function actionItemChildDelete($id)
    {
        if (Yii::$app->request->post()) {
            try {
                $parent = Yii::$app->request->post();

                $child = [];
                foreach ($parent as $key => $name) {
                    foreach ($name as $item) {
                        $child[] = $item;
                    }
                }

                AuthItemChild::deleteAll(['AND', ['parent' => trim($id)], ['in', 'child', $child]]);
            } catch (ErrorException $e) {
                Yii::error($e->getMessage(), 'auth_item');
            }
        } else {
            Yii::error('Not post', 'auth_item');
        }
    }

}
