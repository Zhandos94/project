<?php

namespace frontend\modules\document\controllers;

use Yii;
use backend\modules\document\models\Document;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
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
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
        ];
    }

    /**
     * Lists all Document models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Document::find()->where(['com_id' => \Yii::$app->user->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Document model.
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
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Document();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->upload()) {
                return $this->redirect('index');
            } else {
                Yii::error($model->getErrors(), 'document');
                Yii::$app->session->setFlash('error', Yii::t('app', 'Downloadable file type does not correspond to the categories of documents'));
                return $this->refresh();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionWrite()
    {
        $cat_id = Yii::$app->request->post('val');

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie(['name' => 'category', 'value' => $cat_id]));
        $cat_id_cook = $cookies->getValue('category', 'have not val');

        return json_encode($cat_id_cook);

    }

    public function actionReadCookies()
    {
        $cookies = Yii::$app->request->cookies;
        $cat_id = 'null';
        if ($cookies->has('category')){
            $cat_id = $cookies->getValue('category', 'have not val');
        }
        return json_encode($cat_id);
    }
}
