<?php

namespace common\models\refs;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_contacts_type".
 */
class RefContactsType extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_contacts_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name_ru'], 'string', 'max' => 40],
        ]);
    }
}
