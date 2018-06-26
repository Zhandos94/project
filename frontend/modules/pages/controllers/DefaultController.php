<?php

namespace frontend\modules\pages\controllers;

use backend\modules\pages\models\AuxPagesData;
use backend\modules\pages\models\AuxPagesLangs;
use common\models\SysLang;
use yii\web\Controller;

/**
 * Default controller for the `pages` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @param string $code
     * @return mixed
     */
    public function actionIndex($code = null)
    {
        /* @var $model AuxPagesData */
        $model = AuxPagesData::find()->where(['is_public' => 1, 'code' => $code])->one();
        if ($model === null || empty($model->langs)) {
            $model = AuxPagesData::find()->where(['code' => 'index'])->one();
        }
        $defaultLang = SysLang::langByLocal();
        /* @var $defaultPage AuxPagesLangs */
        $defaultPage = AuxPagesLangs::find()->where(['lang_id' => $defaultLang, 'id' => $model->id])->one();
        if ($defaultPage === null) {
            $defaultLang = SysLang::langByLocal(true);
            $defaultPage = AuxPagesLangs::find()->where(['lang_id' => $defaultLang, 'id' => $model->id])->one();
        }
        return $this->render('index', [
            'content' => $defaultPage->body,
            'title' => $defaultPage->title,
        ]);
    }
}
