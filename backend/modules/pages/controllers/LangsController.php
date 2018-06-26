<?php

namespace backend\modules\pages\controllers;

use Yii;
use backend\modules\pages\models\AuxPagesLangs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LangsController implements the CRUD actions for AuxPagesLangs model.
 */
class LangsController extends Controller
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
     * Lists all AuxPagesLangs models.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuxPagesLangs::find()->where(['id' => $id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }

    /**
     * Displays a single AuxPagesLangs model.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionView($id, $lang_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $lang_id),
        ]);
    }

    /**
     * Creates a new AuxPagesLangs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new AuxPagesLangs();
        $model->id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'lang_id' => $model->lang_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $id
            ]);
        }
    }

    /**
     * Updates an existing AuxPagesLangs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionUpdate($id, $lang_id)
    {
        $model = $this->findModel($id, $lang_id);

        if ($model->load(Yii::$app->request->post())) {
            $model->lang_id = $lang_id;//to save language
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'lang_id' => $model->lang_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuxPagesLangs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $lang_id
     * @return mixed
     */
    public function actionDelete($id, $lang_id)
    {
        $this->findModel($id, $lang_id)->delete();

        return $this->redirect(['index', 'id' => $id]);
    }

    /**
     * Finds the AuxPagesLangs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $lang_id
     * @return AuxPagesLangs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $lang_id)
    {
        if (($model = AuxPagesLangs::findOne(['id' => $id, 'lang_id' => $lang_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
