<?php

namespace backend\modules\document\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "document".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $com_id
 * @property integer $sign_status
 * @property string $name
 * @property string $save_name
 * @property string created_at
 */
class Document extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'name', 'file'], 'required',],
            [['cat_id', 'com_id', 'sign_status'], 'integer'],
            [['created_at', 'updated_at', 'save_name'], 'safe'],
            [['name'], 'string', 'max' => 65],
            [['file'], 'clientValidateAttribute'],
//            [['file'], 'backend\modules\document\component\FileValidator'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'com_id' => 'Com ID',
            'sign_status' => 'Sign Status',
            'name' => 'Name',
            'save_name' => 'Save Name',
            'created_at' => 'Create Date',
            'file' => 'File',
        ];
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {

        $this->message = Yii::t('js', 'The file has not to be in format');


        $formats_name = json_encode(DocFormat::find()->select('name')->column());
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

//        $cookies = Yii::$app->request->cookies;
//        $cat_id = 'nulls';
//        if ($cookies->has('category')){
//            $cat_id = $cookies->getValue('category', 'have not val');
//        }
//        $cat_id = json_encode($cat_id);

        return <<<JS
            if($formats_name.indexOf(value.split('.').pop()) == -1 ){
                messages.push($message + ' .' + value.split('.').pop());
            }
JS;
    }
    /**
     * The function gets name from table "Format"
     * @return array
     */
    public function getFormatName()
    {
        $formats_id = [];
        foreach (DocCategory::findOne($this->cat_id)->docCatFormat as $item) {
            $formats_id[] = $item['for_id'];
        }
        /*По ключу по formats_id  вытаскиваем из таблицы DocFormat наименование значений стлобца */
        $formats_name = DocFormat::find()->select('name')
            ->where(['id' => $formats_id])
            ->column();

        return $formats_name;
    }

    public function getAllFormatName()
    {
        $types_name = '';
        foreach (DocFormat::find()->select('name')->column() as $value) {
            $types_name .= '.' . $value . ', ';
        }

        return $types_name;
    }
    /**
     * The server file validator check file format compliance table
     * document_category_format format_name;
     * @param $attributes
     */


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocCategory()
    {
        return $this->hasOne(DocCategory::className(), ['id' => 'cat_id']);
    }

    /**
     * The function get status document for argument
     * @param string $status
     * @return string
     */
    public static function getDocumentStatus($status)
    {
        return Yii::t('app', ($status == 1 ? 'Signed' : 'Unsigned'));
    }

    /**
     * The function checks the key exists in the table "Document" in column save_name
     * @param string $key
     * @param string $extension
     * @return string
     */
    public function check($key, $extension)
    {
        $save_name = Document::find()->select('save_name')
            ->where(['save_name' => $key . '.' . $extension])
            ->column();

        if ($save_name == $key . '.' . $extension) {
            $key = Yii::$app->security->generateRandomString();
            $this->check($key, $extension);
        }
        return $key . '.' . $extension;
    }


    /**
     * The function uploads file
     * @return bool
     */
    public function upload()
    {
        $success = false;
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->validate()) {
            $key = Yii::$app->security->generateRandomString();
            $save_name = $this->check($key, $this->file->extension);

            $path = Yii::getAlias("@frontend/media/uploads/document/" . $this->cat_id);
            BaseFileHelper::createDirectory($path);

            $save_path = $path . DIRECTORY_SEPARATOR . $save_name;

            if ($this->file->saveAs($save_path)) {
                if ($this->writeDocument($this->name, $this->cat_id, $save_name)) {
                    $success = true;
                } else {
                    unlink($save_path);
                }
            }
        }
        return $success;
    }

    /**
     * The function write data from table "Document"
     * @param string $name
     * @param integer $cat_id
     * @param string $save_name
     * @return bool
     */
    public function writeDocument($name, $cat_id, $save_name)
    {
        $success = false;
        if ($this->validate()) {
            $this->name = $name;
            $this->cat_id = (int)$cat_id;
            $this->com_id = \Yii::$app->user->getId(); //TODO the row for company_id
            $this->save_name = $save_name;
//            $this->create_date = date("Y-m-d H:i:s");
            if ($this->save()) {
                $success = true;
            } else {
                Yii::error($this->getErrors(), 'document');
            }
        }
        return $success;
    }
}
