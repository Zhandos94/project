<?php

namespace backend\modules\dimensions\controllers;

use backend\modules\dimensions\models\LotDimensions;
use backend\modules\dimensions\services\DimGenService;
use backend\modules\dimensions\services\SaveVisualPosition;
use backend\modules\dimensions\services\SqlService;
use common\models\refs\RefLotTypes;
use Yii;
use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\DimDataSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DimDataController implements the CRUD actions for DimData model.
 */
class DimDataController extends Controller
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
     * Lists all DimData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $lotTypeProvider = new ActiveDataProvider([
            'query' => RefLotTypes::find(),
        ]);

        $dimensionSearch = new DimDataSearch();

        $dimensionProvider = $dimensionSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
//            'lotTypeSearch' => $lotTypeSearch,
            'lotTypeProvider' => $lotTypeProvider,
            'dimensionSearch' => $dimensionSearch,
            'dimensionProvider' => $dimensionProvider,
        ]);
    }

    /**
     * Displays a single DimData model.
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
     * Creates a new DimData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DimData();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveDimension()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DimData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->codeId = $id;
        $service = new DimGenService();
        $isEditable = $service->isEditable($id);
        if ($isEditable) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveDimension(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
//            Yii::error('This dimension sum is already being used by the client. lot_attr_val ID: ' . $lotAttributeVal->id, 'dim_data');
            Yii::$app->session->setFlash('error', Yii::t('dim', 'This dimension sum is already being used by the client'));
            return $this->redirect(['index', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing DimData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $result = false;
        $model = $this->findModel($id);
        /* @var $lotDimensions LotDimensions[] */
        $lotDimensions = LotDimensions::find()->where(['dim_id' => $id])->all();
        $model->scenario = $model::SCENARIO_DELETE;
        $model->is_active = $model->is_active ^ 1;
        if ($model->save()) {
            $result = true;
            foreach ($lotDimensions as $lotDim) {
                $lotDim->row_num = NULL;
                $lotDim->col_count = NULL;
                $lotDim->order_in_row = NULL;
                if (!$lotDim->save()) {
                    $result = false;
                }
            }
        }
        if ($result) {
            Yii::$app->session->setFlash('success', Yii::t('dim', 'dimension has been disabled'));
        } else {
            Yii::error($model->getErrors(), 'dim_data');
            Yii::$app->session->setFlash('error', Yii::t('dim', 'dimension has not been saved on disabling'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the DimData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DimData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DimData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFilterDims($lotTypeId)
    {
        $id = LotDimensions::find()->where(['lot_type_id' => $lotTypeId])->select('dim_id')->column();
        $searchModel = new DimDataSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('filter_dims', [
            'dataProvider' => $dataProvider,
            'lotTypeId' => $lotTypeId,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionGetRefColumns()
    {
        $refId = Yii::$app->request->post('refId');
        $genService = new DimGenService();
        $columns = $genService->getRefColumns($refId);
        return json_encode($columns);
    }

    public function actionVisualEdit()
    {
        $lotTypeId = Yii::$app->request->post('lotTypeId');
        $saveVisual = new SaveVisualPosition($lotTypeId);
        if ($saveVisual->execute()) {
            return true;
        } else {
            return 'some error, see logs';
        }
    }

    public function actionVisualConstruct($id)
    {
        $dimension_datas = [];
        /* @var $lot_dimensions LotDimensions[] */
        $lot_dimensions = LotDimensions::find()
            ->where(['lot_type_id' => $id])
            ->orderBy(['order_in_row' => SORT_ASC, 'row_num' => SORT_ASC])
            ->all();
        foreach ($lot_dimensions as $lot_dimension) {
            $dim_data = DimData::findOne($lot_dimension->dim_id);
            $code = $dim_data->code;
            $label = $dim_data->name;
            $isActive = $dim_data->is_active;
            array_push($dimension_datas, [
                'code' => $code,
                'label' => $label,
                'row_num' => $lot_dimension->row_num,
                'col_count' => $lot_dimension->col_count,
                'order_in_row' => $lot_dimension->order_in_row,
                'is_active' => $isActive
            ]);
        }
        return $this->render('visual_construct', [
            'lotTypeId' => $id,
            'lotDimensions' => $dimension_datas
        ]);
    }

    public function actionExportSql()
    {
        $formatter = Yii::$app->formatter;
        $date = $formatter->asDate(time(), 'yyyyMMdd');
        $response = Yii::$app->response;
        $sqlServ = new SqlService();
        $response->sendContentAsFile($sqlServ->exportAll(),
            'sql_dim_export_' . $date . '.txt');
    }

    public function actionAddFilter($id, $lotTypeId)
    {

        /* @var $lotDimension LotDimensions */
        $lotDimension = LotDimensions::find()
            ->where(['dim_id' => $id])
            ->andWhere(['lot_type_id' => $lotTypeId])
            ->one();
        if($lotDimension !== null){
            $lotDimension->in_filter = $lotDimension->in_filter ^ 1;
            if ($lotDimension->save()) {
                $text = $lotDimension->in_filter ? 'added to filter' : 'removed from filter';
                Yii::$app->session->setFlash('success', Yii::t('dim', $text));
            } else {
                Yii::error($lotDimension->getErrors(), 'dim_data');
                Yii::$app->session->setFlash('error', Yii::t('dim', 'dimension has not been saved on adding to filter'));
            }
        }
        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGetFilterList()
    {
        $dimId = Yii::$app->request->post('dimId');
        $service = new DimGenService();
        $lotTypesList = $service->getFilterList($dimId);
        return json_encode($lotTypesList);
    }
}
