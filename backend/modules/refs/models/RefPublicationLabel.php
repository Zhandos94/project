<?php

namespace backend\modules\refs\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_publication_category".
 *
 * @property integer $id
 * @property string $name_kz
 * @property string $name_ru
 * @property integer $disabled
 * @property string $slug
 */
class RefPublicationLabel extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_publication_label';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'slug',
                'attribute' => ['name_ru', 'name_kz'],
                // optional params
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                'immutable' => false,
                // If intl extension is enabled, see http://userguide.icu-project.org/transforms/general.
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return parent::rules();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public static function labelsArray(){
        $labels = RefPublicationLabel::find()->all();
        return ArrayHelper::map($labels, 'id', 'name');
    }
}
