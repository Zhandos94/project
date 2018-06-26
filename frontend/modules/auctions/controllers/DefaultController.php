<?php

namespace frontend\modules\auctions\controllers;

use frontend\modules\auctions\models\AucData;
use frontend\modules\auctions\models\AucImages;
use frontend\modules\auctions\models\AucImagesTemp;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Default controller for the `auctions` module
 */
class DefaultController extends Controller
{
    /**
     * Lists all AutoTable models.
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
     * Displays a single AutoTable model.
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
     * Creates a new AucData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AucData();
        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->save()) {
                    $model->refresh();
                    if ($model->moveTempImg()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
                return $this->redirect(['create', 'id' => $model->id]
                );
            } catch (\ErrorException $e) {
                Yii::info(print_r($e->getMessage(), true), 'auc_log');
                return $this->redirect(['create', 'id' => $model->id]);
            }
        } else {
            $hash = AucData::generateHash();
            return $this->render('create', [
                'model' => $model,
                'hash' => $hash,
            ]);
        }
    }

    /**
     * Updates an existing AutoTable model.
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
     * Deletes an existing AutoTable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $dataProvider = new ActiveDataProvider([
            'query' => AucData::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the AutoTable model based on its primary key value.
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

    public function actionTempSave()
    {
        $model = new AucData();
        $hash = Yii::$app->request->post('hash');
        $model->load(Yii::$app->request->post());
        $model->imageFiles = UploadedFile::getInstance($model, 'imageFiles');
        $output = $model->tempSave($model->imageFiles, $hash);
        $json = json_encode($output);
        return $json;
    }

    public function actionDeleteTempImg()
    {
        $save_name = Yii::$app->request->post('key');
        $hash = Yii::$app->request->post('hash');
        /* @var AucImagesTemp $temp_image */
        $temp_image = AucImagesTemp::find()->where(['save_name' => $save_name])->one();
        if ($temp_image !== null) {
            if ($temp_image->general_img == 1) {
                /* @var $another_img AucImagesTemp */
                $another_img = AucImagesTemp::find()->where(['hash' => $hash])->one();
                $another_img->general_img = 1;
                if (!$another_img->save()) {
                    Yii::info('can not save another general image, id=' . $another_img->id, 'auc_images_log');
                    return json_encode(['error' => Yii::t('app', 'Problem with file')]);
                }
            }
        } else {
            Yii::info('removing image model is not exist', 'auc_images_log');
            return json_encode([]);
        }
        if ($temp_image->delete()) {
            if (file_exists(AucData::getTempPath($hash, $save_name)) &&
                unlink(AucData::getTempPath($hash, $save_name))
            ) {
                return json_encode([]);
            }
        }
        return json_encode([
            'error' => Yii::t('app', 'file is not deleted')
        ]);
    }

    public function actionAjaxDelete($auc_id)
    {
        $model = $this->findModel($auc_id);
        return $model->deleteImg();
    }

    public function actionAjaxUpdateImg($auc_id)
    {
        $model = $this->findModel($auc_id);
        return json_encode($model->uploadImg(UploadedFile::getInstance($model, 'imageFiles')));
    }

    public function actionDoMain($auc_id, $save_name)
    {
        /* @var $img AucImages */
        /* @var $old_main AucImages */
        $img = AucImages::find()->where(['save_name' => $save_name])->one();
        $old_main = AucImages::find()->where(['auc_id' => $auc_id, 'general' => 1])
            ->andWhere(['not',['save_name' => $save_name]])->one();
        $model = $this->findModel($auc_id);
        $fail = false;
        if ($old_main !== null) {
            $old_main->general = 0;
            if(!$old_main->save()){
                $fail = true;
            }
        }
        $img->general = 1;
        if(!$img->save()){
            $fail = true;
        }
        if(!$fail){
            return $this->render('_images',[
                'model' => $model,
                'form' => ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])
            ]);
        } else {
            return $this->render('_images',[
                'model' => $model,
                'form' => ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]),
                'error' => Yii::t('app', 'there was a error')
            ]);
        }
    }

    public function actionTempMain($hash, $save_name)
    {
        $model = new AucData();
        /* @var $temp_image AucImagesTemp */
        $temp_image = AucImagesTemp::find()->where(['save_name' => $save_name])->one();
        /* @var $old_main AucImagesTemp */
        $old_main = AucImagesTemp::find()->where(['general_img' => 1, 'hash' => $hash])
            ->andWhere(['not',['save_name' => $save_name]])->one();
        $fail = false;
        if ($old_main !== null) {
            $old_main->general_img = 0;
            if(!$old_main->save()){
                $fail = true;
            }
        }
        $temp_image->general_img = 1;
        if(!$temp_image->save()){
            $fail = true;
        }
        if(!$fail){
            return $this->render('_images', [
                'model' => $model,
                'hash' => $hash,
                'form' => ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]),
            ]);
        } else {
            return $this->render('_images', [
                'model' => $model,
                'form' => ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]),
                'hash' => $hash,
                'error' => Yii::t('app', 'there was a error'),
            ]);
        }
    }
}
