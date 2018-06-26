<?php
/**
 * Created by BADI.
 * DateTime: 18.12.2016 14:05
 */

namespace frontend\controllers;


use backend\modules\dimensions\models\DimData;
use common\models\LotAttributeVal;
use common\services\dimensions\Get;
use Yii;
use yii\web\Controller;

class GetAttrController extends Controller
{

    public function actionValidateAttrVals()
    {
        $model = new LotAttributeVal();
        $model->lotTypeId = Yii::$app->request->post('lotTypeId');
//        return json_encode(false);
        return json_encode($model->validate());
    }

    public function actionGetDynamicForm()
    {
        $lotTypeId = Yii::$app->request->post('lotTypeId');

        return $this->renderAjax('_attributes', [
            'lotTypeId' => $lotTypeId,
            'lotAttrErr' => json_encode([]),
        ]);
    }

    public function actionGetDepDrop()
    {
        $post = Yii::$app->request->post();
        $parCode = $post['parent'];
        $chCode = $post['child'];
        $parDimVal = $post['parentVal'];
        /* @var $parDim DimData */
        $parDim = DimData::find()->where(['code' => $parCode])->one();
        $chDim = DimData::find()->where(['code' => $chCode])->one();
        $getService = new Get();
        $list = $getService->dependentList($parDimVal, $chDim, $parDim->id);
        return json_encode($list);
    }
}