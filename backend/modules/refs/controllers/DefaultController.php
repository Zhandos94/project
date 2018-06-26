<?php

namespace backend\modules\refs\controllers;

use backend\modules\refs\models\MetaTable;
use backend\modules\refs\services\RefService;
use yii\base\Exception;
use yii\db\Query;
use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Default controller for the `refs` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @param $table_name string
     * @return string
     */

    public function actionIndex($table_name)
    {
        $query = (new Query())->from($table_name);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'table_name' => $table_name,
            'prim_key' => RefService::getPrimarykey($table_name),
            'columns' => RefService::getColumns($table_name),
        ]);
    }

    public function actionView($table_name, $prim_key)
    {
        $model = RefService::findModel($table_name, $prim_key);
        return $this->render('view', [
            'model' => $model,
            'prim_key' => $prim_key,
            'table_name' => $table_name,
            'columns' => RefService::getColumns($table_name),
        ]);
    }

    public function actionCreate($table_name)
    {
        $model = RefService::findModel($table_name);
        $prim_key = RefService::getPrimarykey($table_name);
        /* @var $meta_model MetaTable */
        $meta_model = MetaTable::find()->where(['table_name' => $table_name])->one();
        if ($model->load(Yii::$app->request->post())) {
            $transactions = Yii::$app->db->beginTransaction();
            try {
                $status_ok = false;
                if ($model->save() && $meta_model->writeLogs($model->$prim_key, 'create')) {
                    $status_ok = true;
                }
                if ($status_ok) {
                    $transactions->commit();
                }
                return $this->redirect(['index', 'table_name' => $table_name]);
            } catch (Exception $e) {
                $transactions->rollBack();
            }
        }
        return $this->render('create', [
            'model' => $model,
            'table_name' => $table_name,
            'columns' => RefService::getColumns($table_name),
            'prim_key' => $prim_key,
        ]);
    }

    public function actionUpdate($table_name, $prim_key_val)
    {
        $model = RefService::findModel($table_name, $prim_key_val);
        /* @var $meta_model MetaTable */
        $meta_model = MetaTable::find()->where(['table_name' => $table_name])->one();
        if ($model->load(Yii::$app->request->post())) {
            $transactions = Yii::$app->db->beginTransaction();
            try {
                $status_ok = false;
                if ($model->save() && $meta_model->writeLogs($prim_key_val, 'update')) {
                    $status_ok = true;
                }
                if ($status_ok) {
                    Yii::$app->session->setFlash('success', 'save');
                    $transactions->commit();
                }
                return $this->redirect(['index', 'table_name' => $table_name]);
            } catch (Exception $e) {
                $transactions->rollBack();
            }
        }
        return $this->render('update', [
            'model' => $model,
            'table_name' => $table_name,
            'columns' => RefService::findTable($table_name)->columnNames,
            'prim_key' => RefService::getPrimarykey($table_name),
            'prim_key_val' => $prim_key_val,
        ]);
    }

    public function actionDelete($table_name, $prim_key)
    {
        $model = RefService::findModel($table_name, $prim_key);
        $columns = RefService::getColumns($table_name);
        /* @var $meta_model MetaTable */
        $meta_model = MetaTable::find()->where(['table_name' => $table_name])->one();
        foreach ($columns as $column) {
            if ($column == 'disabled') {
                $transactions = Yii::$app->db->beginTransaction();
                try {
                    $status_ok = false;
                    $model->disabled = $model->disabled ^ 1;
                    if ($model->save()) {

                        $disabled = $model->disabled == 0 ? 'enable' : 'disable';
                        if ($meta_model->writeLogs($prim_key, $disabled)) {
                            $status_ok = true;
                        } else {
                            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Can not write to logs'));
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Can not save disabled'));
                    }
                    if ($status_ok) {
                        $transactions->commit();
                    }
                    return $this->redirect(['index', 'table_name' => $table_name]);
                } catch (Exception $e) {
                    $transactions->rollBack();
                }
            }
        }
        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Do not have disabled column'));
        return $this->redirect(['index', 'table_name' => $table_name]);
    }

    public function actionGenerateSql($table_name)
    {
        $formatter = Yii::$app->formatter;
        $date = $formatter->asDate(time(), 'yyyyMMdd');
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->content = RefService::generateSqlCommands($table_name);
        $response->sendContentAsFile(RefService::generateSqlCommands($table_name), 'sql_' . $table_name . '_' . $date . '.txt');
    }
}
