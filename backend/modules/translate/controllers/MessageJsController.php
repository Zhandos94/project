<?php

namespace backend\modules\translate\controllers;

use kartik\form\ActiveForm;
use Yii;
use backend\modules\translate\models\MessageJs;
use backend\modules\translate\models\SourceMessage;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * ZetMessageController implements the CRUD actions for MessageJsmodel.
 */
class MessageJsController extends Controller
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
	 * Lists all MessageJsmodels.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$sort = new Sort([
			'attributes' => [
				'id',
				'message' => [
					'asc' => ['message' => SORT_ASC, 'id' => SORT_ASC],
					'desc' => ['message' => SORT_DESC, 'id' => SORT_DESC],
					'default' => SORT_DESC,
					'label' => 'Message',
				],
			],
		]);

        $dataProvider = new ActiveDataProvider([
			'query' => MessageJs::find(),
			'pagination' => ['pageSize' => 10],
			'sort' => $sort,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single MessageJsmodel.
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
	 * Deletes an existing MessageJsmodel.
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
		if (($model = MessageJs::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

    /**
     * Client validate form
     * @return array
     */
	public function  actionValid(){
        $source_message = new SourceMessage();
        if (Yii::$app->request->isAjax && $source_message->load(Yii::$app->request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($source_message);
        }
    }

    /**
     * This is action add message in table source_message.
     * @param $id integer
     * @return mixed
     */
	public function  actionAddMessage($id)
	{
        $message_js = $this->findModel($id);
        if (SourceMessage::find()->select('message')->where(['message' => $message_js->message])->one() === null) {
            $source_message = new SourceMessage();
            $source_message->message = $message_js->message;
            $source_message->category = '_js';

            if ($source_message->load(Yii::$app->request->post())) {

                if ($source_message->save()) {
                    $source_message->saveTranslates();
                    $message_js->deleteAll('message = :mes', array(':mes' => $message_js->message));
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Message has been successfully added!'));
                    return $this->redirect(['index']);
                } else {
                    Yii::error($source_message->getErrors(), 'message_log');
                }

            } else {
                Yii::error('I did not enter the post!', 'message_log');
                return $this->redirect(['index']);
            }
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'The message has had in table!'));
            $message_js->deleteAll('message = :mes', array(':mes' => $message_js->message));
            return $this->redirect(['index']);
        }
    }


}
