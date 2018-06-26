<?php

namespace app\modules\admin\controllers;

use backend\modules\admin\components\ItemController;
use Yii;
use yii\web\NotFoundHttpException;
use backend\modules\admin\models\User;
use backend\modules\admin\models\LogUser;
use backend\modules\admin\models\LogUserSearch;

/**
 * LogUserController implements the CRUD actions for LogUser model.
 */
class LogUserController extends ItemController
{

    /**
     * Lists all LogUser models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new LogUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the LogUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * The action realize log_user
     * @param integer $id
     * @return mixed
     */
    public function actionChange($id)
    {
        $model = User::findOne($id);

        $status = User::STATUS_INACTIVE;
        if ($model->status == $status) {
            $status = User::STATUS_ACTIVE;
        }

        $model->status = $status;
        $model->save();

        $log_user = new LogUser();

        if ($log_user->load(Yii::$app->request->post())) {

            if($log_user->writeLogUser($id, $status == User::STATUS_INACTIVE ? 1 : 2, $log_user->reason)){
                Yii::$app->session->setFlash('success', Yii::t('app', $status == 0 ? 'User has been disabled' : 'User has been activated'));
            } else {
                Yii::error($log_user->getErrors(), 'log_user');
                Yii::$app->session->setFlash('error', Yii::t('app', $status == 0 ? 'User has not been saved as disabled' : 'User has not been saved as activated'));
            }

        }
        return $this->redirect(['user/index']);
    }
}
