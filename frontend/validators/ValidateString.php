<?php
/**
 * Created by BADI.
 * DateTime: 09.12.2016 16:33
 */

namespace frontend\validators;


class ValidateString extends AttributeValueValidator
{

    private function className()
    {
        return 'ValidateString';
    }

    /**
     * @return boolean|string
     */
    public function execute()
    {
        $validate = true;
        if (strlen($this->attribute) > $this->dimension->max_length) {
            $this->writeLog($this->className());
            $validate = [];
            $validate['message'] = \Yii::t('dim', '{attribute} length must be no greater than {max}',
                [
                    'attribute' => \Yii::t('dim', $this->dimension->name),
                    'max' => $this->dimension->max_length,
                ]);
        }
        if(strlen($this->attribute) < $this->dimension->min_length){
            $this->writeLog($this->className());
            $validate = [];
            $validate['message'] = \Yii::t('dim', '{attribute} length must be more than {min}',
                [
                    'attribute' => \Yii::t('dim', $this->dimension->name),
                    'min' => $this->dimension->min_length,
                ]);
        }
        if($validate !== true){
            $validate['id'] = $this->jsId;
        }
        return $validate;
    }
}