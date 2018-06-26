<?php
/**
 * Created by BADI.
 * DateTime: 09.12.2016 18:21
 */

namespace frontend\validators;


class ValidateCheckBox extends AttributeValueValidator
{

    private function className()
    {
        return 'ValidateCheckBox';
    }

    public function execute()
    {
        $validate = true;
        if ($this->attribute != 0 && $this->attribute != 1) {
            $this->writeLog($this->className());
            $validate = [];
            $validate['message'] = \Yii::t('dim', 'Incorrect value of {attribute}',
                [
                    'attribute' => \Yii::t('dim', $this->dimension->name),
                ]);
            $validate['id'] = $this->jsId;
        }
        return $validate;
    }
}