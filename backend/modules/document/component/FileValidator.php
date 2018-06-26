<?php
/**
 * Created by PhpStorm.
 * User: mrdos
 * Date: 01.02.2017
 * Time: 14:57
 */

namespace backend\modules\document\component;

use backend\modules\document\models\DocFormat;
use Yii;
use yii\base\Controller;
use yii\validators\Validator;
use yii\httpclient\Client;



class FileValidator extends Validator
{

    public $message;

    public function init()
    {
        parent::init();
        $this->message = Yii::t('js', 'The file has not to be in format');
    }

    /**
     * The server file validator check file format compliance table "Document Category Format"
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $file = $model->$attribute;

        if (!in_array($file->extension, $model->getFormatName())) {
            $this->addError($model, $attribute, ('The category_id = ' . $model->cat_id . ', must not been format =>' . $file->extension));
        }
    }

    /**
     * Client validator checks the file format in accordance with the table "Document format"
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param \yii\web\View $view
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {

//        $url = Yii::$app->controller->module->params['url'];
//        $client = new Client();
//        $response = $client->createRequest()->setMethod('get')
//            ->setUrl('http://project.com/document/document/read-cookies')
//            ->send();
////
//        $cat_id = $response->content;

        $formats_name = json_encode(DocFormat::find()->select('name')->column());
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $cookies = Yii::$app->request->cookies;
        $cat_id = 'nulls';
        if ($cookies->has('category')){
            $cat_id = $cookies->getValue('category', 'have not val');
        }
        $cat_id = json_encode($cat_id);

        return <<<JS
            if($formats_name.indexOf(value.split('.').pop()) == -1 ){
                    console.log($cat_id);
                messages.push($message + ' .' + value.split('.').pop());
            }
JS;
    }


}