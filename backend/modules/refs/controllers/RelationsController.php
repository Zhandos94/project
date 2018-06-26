<?php

namespace backend\modules\refs\controllers;

use backend\modules\refs\services\RelationService;
use backend\modules\refs\services\SaveRelationService;
use Yii;
use backend\modules\refs\models\RefRelationsTable;
use backend\modules\refs\models\RefRelationsTableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RelationsController implements the CRUD actions for RefRelationsTable model.
 */
class RelationsController extends Controller
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
     * Lists all RefRelationsTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefRelationsTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefRelationsTable model.
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
     * Creates a new RefRelationsTable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RefRelationsTable();
        $relService = new RelationService();
        $relCols = $relService->getColumnModels();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = false;
                if ($model->save()) {
                    $saveRel = new SaveRelationService($model->id);
                    if ($saveRel->execute()) {
                        $success = true;
                    } else {
                        Yii::$app->session->setFlash('error',
                            Yii::t('ref', 'have not been saved relation COLUMNs, see logs'));
                    }
                } else {
                    Yii::$app->session->setFlash('error',
                        Yii::t('ref', 'have not been saved relation TABLEs, see logs'));
                    Yii::error($model->getErrors(), 'ref_relations');
                }
                if ($success) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\ErrorException $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), 'ref_relations');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'relCols' => $relCols,
        ]);
    }

    /**
     * Updates an existing RefRelationsTable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $relService = new RelationService();
        $relCols = $relService->getColumnModels($id);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = false;
                if ($model->save()) {
                    $saveRel = new SaveRelationService($model->id);
                    if ($saveRel->execute()) {
                        $success = true;
                    } else {
                        Yii::$app->session->setFlash('error',
                            Yii::t('ref', 'have not been saved relation COLUMNs, see logs'));
                    }
                } else {
                    Yii::$app->session->setFlash('error',
                        Yii::t('ref', 'have not been saved relation TABLEs, see logs'));
                    Yii::error($model->getErrors(), 'ref_relations');
                }
                if ($success) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\ErrorException $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), 'ref_relations');
            }
        }
        return $this->render('update', [
            'model' => $model,
            'relCols' => $relCols,
        ]);
    }

    /**
     * Deletes an existing RefRelationsTable model.
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
     * Finds the RefRelationsTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefRelationsTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefRelationsTable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
