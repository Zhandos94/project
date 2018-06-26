<?php
/**
 * Created by BADI.
 * DateTime: 11.12.2016 14:10
 */

namespace frontend\validators;


use frontend\helpers\NumericHelper;

class ValidateNumeric extends AttributeValueValidator
{

    private function className()
    {
        return 'ValidateNumeric';
    }

    public function execute()
    {
        $validate = true;
        $this->attribute = preg_replace('/\s+/', '',$this->attribute);
        if (is_numeric($this->attribute)) {
//            $this->clearValue();
            $this->attribute = NumericHelper::reformatting($this->attribute);
            if ($this->attribute > 0) {
                $checkValues = $this->checkValues();
                if ($checkValues === true) {
                    if ($this->isFloat()) {
                        //TODO work with count of decimal symbols
                    }
                } else {
                    $validate = $checkValues;
                }
            } else {
                if (!$this->dimension->negative_allow) {
                    $this->writeLog($this->className());
                    $validate = [];
                    $validate['message'] = \Yii::t('dim', '{attribute} must be no less than 0', [
                        'attribute' => \Yii::t('dim', $this->dimension->name),
                    ]);
                    $validate['id'] = $this->jsId;
                }
            }
        } else {
            $this->writeLog($this->className());
            $validate = [];
            $validate['message'] = \Yii::t('dim', '{attribute} value is incorrect',
                ['attribute' => \Yii::t('dim', $this->dimension->name)]);
            $validate['id'] = $this->jsId;
        }

        return $validate;
    }

    private function checkValues()
    {
        $validate = true;
        $text = null;
        $max = $this->dimension->max_val;
        $min = $this->dimension->min_val;
        if ($max !== null && $this->attribute > $max) {
            $text = \Yii::t('dim', '{attribute} must be no greater than {max}', [
                'attribute' => \Yii::t('dim', $this->dimension->name),
                'max' => $max
            ]);
        }
        if ($min !== null && $this->attribute < $min) {
            $text = \Yii::t('dim', '{attribute} must be no less than {min}', [
                'attribute' => \Yii::t('dim', $this->dimension->name),
                'min' => $min
            ]);
        }

        if ($text !== null) {
            $validate = [];
            $validate['message'] = $text;
            $validate['id'] = $this->jsId;
        }

        return $validate;
    }

    private function isFloat()
    {
        return preg_match('/\./', $this->attribute);
    }
}