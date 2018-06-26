<?php

namespace backend\modules\dimensions\controllers;

use Yii;
use backend\modules\dimensions\models\LotDimensions;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LotDimController implements the CRUD actions for LotDimensions model.
 */
class LotDimController extends Controller
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
     * Lists all LotDimensions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => LotDimensions::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LotDimensions model.
     * @param integer $dim_id
     * @param integer $lot_type_id
     * @return mixed
     */
    public function actionView($dim_id, $lot_type_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($dim_id, $lot_type_id),
        ]);
    }

    /**
     * Creates a new LotDimensions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LotDimensions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dim_id' => $model->dim_id, 'lot_type_id' => $model->lot_type_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LotDimensions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $dim_id
     * @param integer $lot_type_id
     * @return mixed
     */
    public function actionUpdate($dim_id, $lot_type_id)
    {
        $model = $this->findModel($dim_id, $lot_type_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dim_id' => $model->dim_id, 'lot_type_id' => $model->lot_type_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LotDimensions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $dim_id
     * @param integer $lot_type_id
     * @return mixed
     */
    public function actionDelete($dim_id, $lot_type_id)
    {
        $this->findModel($dim_id, $lot_type_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LotDimensions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $dim_id
     * @param integer $lot_type_id
     * @return LotDimensions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($dim_id, $lot_type_id)
    {
        if (($model = LotDimensions::findOne(['dim_id' => $dim_id, 'lot_type_id' => $lot_type_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
