<?php

namespace backend\modules\dimensions\controllers;

use Yii;
use backend\modules\dimensions\models\DimVisibilitySettings;
use backend\modules\dimensions\models\DimVisibilitySettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VisibilitySettingsController implements the CRUD actions for DimVisibilitySettings model.
 */
class VisibilitySettingsController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all DimVisibilitySettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DimVisibilitySettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DimVisibilitySettings model.
     * @param integer $parent_dim_id
     * @param integer $child_dim_id
     * @return mixed
     */
    public function actionView($parent_dim_id, $child_dim_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($parent_dim_id, $child_dim_id),
        ]);
    }

    /**
     * Creates a new DimVisibilitySettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DimVisibilitySettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent_dim_id' => $model->parent_dim_id, 'child_dim_id' => $model->child_dim_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DimVisibilitySettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $parent_dim_id
     * @param integer $child_dim_id
     * @return mixed
     */
    public function actionUpdate($parent_dim_id, $child_dim_id)
    {
        $model = $this->findModel($parent_dim_id, $child_dim_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'parent_dim_id' => $model->parent_dim_id, 'child_dim_id' => $model->child_dim_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DimVisibilitySettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $parent_dim_id
     * @param integer $child_dim_id
     * @return mixed
     */
    public function actionDelete($parent_dim_id, $child_dim_id)
    {
        $this->findModel($parent_dim_id, $child_dim_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DimVisibilitySettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $parent_dim_id
     * @param integer $child_dim_id
     * @return DimVisibilitySettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent_dim_id, $child_dim_id)
    {
        if (($model = DimVisibilitySettings::findOne(['parent_dim_id' => $parent_dim_id, 'child_dim_id' => $child_dim_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
