<?php
/* Attention! For This project as example, not used now. TOLK*/
namespace backend\modules\refs\models;

use yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_region".
 *
 * @property string $code
 * @property string $ab
 * @property string $full_name_ru
 * @property string $full_name_kz
 */
class RefRegion extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['code'], 'string', 'max' => 10],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'full_name_ru' => Yii::t('app', 'full_name_ru'),
            'full_name_kz' => Yii::t('app', 'full_name_kz'),
        ]);
    }

    static public function getListArray() {
        $key = 'array_'.self::tableName();
        $rcache = Yii::$app->rcache;

        $data = $rcache->get($key);

        if ($data === false) {
            $data = ArrayHelper::map(RefRegion::find()->all(), 'id', 'name');
            $rcache->set($key, $data);
        }

        return $data;
    }

}
