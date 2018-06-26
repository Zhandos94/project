<?php

namespace frontend\controllers;

use common\models\LotAttributeVal;
use frontend\models\Lot;
use Yii;
use frontend\models\AucData;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AucDataController implements the CRUD actions for AucData model.
 */
class AucDataController extends Controller
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
	 * Lists all AucData models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => AucData::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single AucData model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		$lot = Lot::find()->where(['auc_id' => $id])->one();
		$model->lotTypeId = $lot->lot_type_id;
		$errors = json_encode([]);
		return $this->render('view', [
			'model' => $model,
			'lotModel' => $lot,
			'lotAttrErr' => $errors

		]);
	}

	/**
	 * Creates a new AucData model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new AucData();
		$lot = new Lot();
		$errors = [];
		if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$success = false;
				if ($model->save()) {
					$lot = $model->saveLot();
					if ($lot !== false) {

						$lotAttrVal = new LotAttributeVal();
						$lotAttrVal->lotTypeId = $model->lotTypeId;
						$validateAttrs = $lotAttrVal->validate();
						if ($validateAttrs === true) {
							if ($lotAttrVal->saveValues($lot)) {
								$success = true;
							} else {
								Yii::$app->session->setFlash('error', 'save values');
							}
						} else {
							Yii::$app->session->setFlash('error', 'validate attr');
							$errors = $validateAttrs;
						}
					} else {
						Yii::$app->session->setFlash('error', 'lot not saved');
					}
				} else {
					Yii::error($model->getErrors(), 'auc_data');
				}
				if ($success) {
					$transaction->commit();
					return $this->redirect(['view', 'id' => $model->id]);
				}
			} catch (\ErrorException $e) {
				Yii::error("message from catch of transaction\n" . $e->getMessage(), 'auc_data');
				$transaction->rollBack();
			}
		}
		$errors = json_encode($errors);
		return $this->render('create', [
			'model' => $model,
			'lotModel' => $lot,
			'lotAttrErr' => $errors,
		]);

	}

	/**
	 * Updates an existing AucData model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		/* @var $lot Lot */
		$lot = Lot::find()->where(['auc_id' => $id])->one();
		$model->lotTypeId = $lot->lot_type_id;
		$lotAttrVal = new LotAttributeVal();
		$errors = [];
//        Yii::error(print_r(Yii::$app->request->post(), true), 'auc_data');
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$success = false;
				if ($model->save()) {
//                    Yii::error('auc saved success', 'auc_data');
					$lot = $model->saveLot();
					if ($lot !== false) {
						$validateAttr = $lotAttrVal->validate();
						Yii::error($validateAttr, 'auc_data');
						if ($validateAttr === true) {
							if ($lotAttrVal->saveValues($lot)) {
								$success = true;
							} else {
								Yii::$app->session->setFlash('info', 'values not saved');
							}
						} else {
							Yii::$app->session->setFlash('error', 'test');
							$errors = $validateAttr;
						}
					} else { // lot has not been saved

					}
				} else { // auction has not been saved
					Yii::error($model->getErrors(), 'auc_data');
				}
				if ($success) {
					$transaction->commit();
					return $this->redirect(['view', 'id' => $model->id]);
				}
			} catch (\ErrorException $e) {
				Yii::error("message from catch of transaction\n" . $e->getMessage(), 'auc_data');
				$transaction->rollBack();
			}
		}
		$errors = json_encode($errors);
		return $this->render('update', [
			'model' => $model,
			'lotModel' => $lot,
			'lotAttrErr' => $errors,
		]);
	}

	/**
	 * Deletes an existing AucData model.
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
	 * Finds the AucData model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return AucData the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = AucData::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
