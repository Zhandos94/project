<?php

namespace frontend\modules\helps\controllers;

use yii\web\Controller;
use Yii;
use backend\modules\helps\models\HelpIntro;
use backend\modules\translate\models\Message;
use frontend\modules\helps\service\HelpService;

/**
 *
 */
class DefaultController extends Controller
{
	/**
	 * actionGetHelpJson show help
	 * @param  string $page_id the name of the first-class after container
	 * @param  string $lang    current language
	 * @return HelpIntro
	 */
	public function actionGetHelpJson($page_id, $lang)
	{
		if ($lang == 'en') {
			$lang = $lang . '-US';
		} else {
			$lang = $lang . '-' . strtoupper($lang);
		}
		$models = HelpIntro::find()
            ->select(['element_id', 'body', 'position', 'page_id', 'is_only', 'is_main', 'step'])
            ->where(['page_id' => $page_id])
            ->asArray()->all();
		foreach ($models as $index => &$model) {

			foreach ($model as $key => &$value) {
				if ($key === 'body') {
					$translate = Message::find()->where(['id' => $value, 'language' => $lang])->one()->translation;
					if ($translate !== null) {
						$model[$key] = $translate;
					} else {
						 $model[$key] = '';
					}
				}
			}
		}
		return json_encode($models);
	}

	/**
	 * actionEdit create and update hint
	 * @return string element_id create element ID
	 */
	public function actionEdit()
	{
        $model = new HelpIntro();
        if ($model->load(Yii::$app->request->post())) {
            if ((boolean) $model->update_model) {
                $response = HelpService::responseForUpdate($model);
            } else {
                $response = HelpService::responseForSave($model);
            }
            if ($response->isOk) {
                return $response->content;
            } /*else {
                return json_encode('bad');
            }*/
        }

	}

	/**
	 * [actionGetElementIdData return datas element ID, for form]
	 * @param  string $page_id the name of the first-class after container
	 * @param  string $element_id the name element ID
	 * @return array
	 */
	public function actionGetElementIdData($page_id, $element_id)
	{
        $response = HelpService::responseForElementData($page_id, $element_id);
        if ($response->isOk) {
            return $response->content;
        } /*else {
            return json_encode('baaad');
        }*/
	}
}

?>
