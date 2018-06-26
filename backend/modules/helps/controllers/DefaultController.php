<?php

namespace backend\modules\helps\controllers;

use Yii;
use backend\modules\helps\models\HelpIntro;
use backend\modules\helps\models\HelpIntroSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\translate\models\SourceMessage;
use backend\modules\translate\models\Message;

/**
 * DefaultController implements the CRUD actions for HelpIntro model.
 */
class DefaultController extends Controller
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
	 * Lists all HelpIntro models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new HelpIntroSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single HelpIntro model.
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
	 * Creates a new HelpIntro model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new HelpIntro();
        if ($model->load(Yii::$app->request->post())) {
            try {
                $is_frontend = $model->is_frontend;
                if (!HelpIntro::find()->where(['page_id' => $model->page_id, 'element_id' => $model->element_id])->one()) {
                    $sourceMessage = new SourceMessage;
                    $sourceMessage->category = Yii::$app->controller->module->params['category'];
                    $sourceMessage->message = $model->message;
                    if ($sourceMessage->save() && $sourceMessage->saveTranslates()) {
                        $message = Message::find()->where(['id' => $sourceMessage->id, 'language' => $model->langs])->one();
                        $message->translation = $model->body;
                        $model->body = $sourceMessage->id;
                        if ($model->save() && $message->save()) {
                            if ($is_frontend) {
                                return json_encode($model->element_id);
                            }
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            Yii::error($model->getErrors(), 'hint_log');
                        }
                    } else {
                        Yii::error('It has been preserved SourceMessage or failed to create translation in Message', 'hint_log');

                    }
                } else {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'This hint already exists'));
                    Yii::error('An attempt to add an existing hint', 'hint_log');
                }
            } catch (Exception $e) {
                Yii::error($e->getMessage(), 'hint_log');
            }
		} else {
            Yii::error('Could not load the data model of the form, ' . print_r(Yii::$app->request->post('HelpIntro'), true), 'hint_log');
        }
		return $this->render('create', ['model' => $model]);
	}

	/**
	 * Updates an existing HelpIntro model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
        try {
            if (Yii::$app->request->post('HelpIntro')) {
                $modelForm = Yii::$app->request->post('HelpIntro');
                $langs = $modelForm['langs'];
            } else {
                $langs = Yii::$app->language;
            }
            $model = $this->findModel($id);
            $translate_id = $model->body;
            $sourceMessage = SourceMessage::findOne($translate_id);
            $message = Message::find()->where(['id' => $translate_id, 'language' => $langs])->one();
            if ($model->load(Yii::$app->request->post())) {
                $is_frontend = $model->is_frontend;
                $sourceMessage->message = $model->message;
                $message->translation = $model->body;
                $model->body = $sourceMessage->id;
                if ($model->save() && $sourceMessage->save() && $message->save()) {
                    if ($is_frontend) {
                        return json_encode($model->element_id);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::error($model->getErrors() .'\n' . $sourceMessage->getErrors() . '\n' . $message->getErrors());
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'translate' => [
                        'message' => $sourceMessage->message,
                        'translation' => $message->translation,
                    ],
                ]);
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), 'hint_log');
        }
	}

	/**
	 * Deletes an existing HelpIntro model.
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
	 * Finds the HelpIntro model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return HelpIntro the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = HelpIntro::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionGetElementIdData($page_id, $element_id, $curr_lang)
    {
        try {
            $model = HelpIntro::find()->select(['body', 'position', 'description', 'is_only', 'is_main', 'step'])->where(['page_id' => $page_id, 'element_id' => $element_id])->one();
            $source_message = SourceMessage::findOne($model->body);
            $message = Message::find()->where(['id' => $source_message->id, 'language' => $curr_lang])->one();
            if ($message->translation) {
                $translation = $message->translation;
                $language = $message->language;
            } else {
                $message_all = Message::find()->select(['translation', 'language'])->where(['id' => $model->body])->asArray()->all();
                for ($i = 0; $i < count($message_all); $i++) {
                    if ($message_all[$i]['translation']) {
                        $translation = $message_all[$i]['translation'];
                        $language = $message_all[$i]['language'];
                    }
                }
            }

            $result = [
                'body' => $translation,
                'position' => $model->position,
                'description' => $model->description,
                'is_only' => $model->is_only,
                'is_main' => $model->is_main,
                'message' => $source_message->message,
                'lang' => $language,
                'step' => $model->step
            ];
            return json_encode($result);
        } catch (Exception $e) {
        }
    }

    public function beforeAction($action)
    {
        if ($action->id === 'create' || $action->id === 'update') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

}
