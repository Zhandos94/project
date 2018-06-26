<?php

namespace backend\modules\refs\controllers;

use backend\modules\refs\models\RefDynamicTableData;
use backend\modules\refs\services\DynamicDataService;
use Yii;
use backend\modules\refs\models\RefDynamicTableName;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DynamicController implements the CRUD actions for RefDynamicNames model.
 */
class DynamicController extends Controller
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
     * Lists all RefDynamicNames models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RefDynamicTableName::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefDynamicNames model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RefDynamicNames model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefDynamicTableName();
        $dynamicService = new DynamicDataService();
        $dataModels = $dynamicService->getDynamicModels();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = false;
                if ($model->save()) {
                    if (RefDynamicTableData::saveData($model->id)) {
                        Yii::$app->session->setFlash('success', 'save');
                        $success = true;
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('ref', 'Has not been saved children dynamic models'));
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('ref', 'Has not been saved parent dynamic model'));
                    Yii::error($model->getErrors(), 'ref_dynamic');
                }
                if ($success) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\ErrorException $e) {
                Yii::error($e->getMessage(), 'ref_dynamic');
                $transaction->rollBack();
            }
        }
        return $this->render('create', [
            'model' => $model,
            'dataModels' => $dataModels,
        ]);
    }

    /**
     * Updates an existing RefDynamicNames model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dynamicService = new DynamicDataService();
        $dataModels = $dynamicService->getDynamicModels($id);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = false;
                if ($model->save()) {
                    if (RefDynamicTableData::saveData($model->id)) {
                        $success = true;
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'Has not been saved children dynamic models'));
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Has not been saved parent dynamic model'));
                    Yii::error($model->getErrors(), 'ref_dynamic');
                }
                if ($success) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\ErrorException $e) {
                Yii::error($e->getMessage(), 'ref_dynamic');
                $transaction->rollBack();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'dataModels' => $dataModels,
        ]);
    }

    /**
     * Deletes an existing RefDynamicNames model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RefDynamicNames model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefDynamicTableName the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefDynamicTableName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * this action only for modal window on create dimensions and will be overwrite
    */
    public function actionCreateModal()
    {
        $model = new RefDynamicTableName();
        $response = [];
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = false;
                if ($model->save()) {
                    if (RefDynamicTableData::saveData($model->id)) {
                        $success = true;
                    } else {
                        $response['error']['message'] = Yii::t('app', 'Has not been saved children dynamic models');
                    }
                } else {
                    $response['error']['message'] = Yii::t('app', 'Has not been saved parent dynamic model');
                    Yii::error($model->getErrors(), 'ref_dynamic');
                }
                if ($success) {
                    $transaction->commit();
                    $response['success']['name'] = $model->name;
                    $response['success']['id'] = $model->id;
                }
            } catch (\ErrorException $e) {
                Yii::error($e->getMessage(), 'ref_dynamic');
                $transaction->rollBack();
                $response['error']['message'] = $e->getMessage();
            }
        }
        return json_encode($response);
    }
}
