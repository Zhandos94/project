<?php
/**
 * Created by BADI.
 * DateTime: 09.12.2016 20:40
 */

namespace frontend\validators;


use yii\validators\DateValidator;

class ValidateDatetime extends AttributeValueValidator
{
    private function className()
    {
        return 'ValidateDatetime';
    }

    public function execute()
    {
        $validate = true;
        $maxDate = $this->dimension->max_date;
        $minDate = $this->dimension->min_date;
        if (!$this->datetimeValidate() && !$this->dateValidate()) {
            $validate = [];
            $validate['message'] = \Yii::t('dim', '{attribute} value is incorrect',
                ['attribute' => \Yii::t('dim', $this->dimension->name)]);
            $validate['id'] = $this->jsId;
            $this->writeLog($this->className());
        } else {
            if ($this->attribute > $maxDate) {
                $validate = [];
                $validate['message'] = \Yii::t('dim', '{attribute} may not be later than {maxDate}', [
                    'attribute' => \Yii::t('dim', $this->dimension->name),
                    'maxDate' => $maxDate
                ]);
                $validate['id'] = $this->jsId;
                $this->writeLog($this->className());
            }
            if ($this->attribute < $minDate) {
                $validate = [];
                $validate['message'] = \Yii::t('dim', '{attribute} may not be early than {minDate}', [
                    'attribute' => \Yii::t('dim', $this->dimension->name),
                    'minDate' => $minDate
                ]);
                $validate['id'] = $this->jsId;
                $this->writeLog($this->className());
            }
        }
        return $validate;
    }

    private function dateValidate()
    {
        $validator = new DateValidator();
        $validator->format = 'php:Y-m-d';
        return $validator->validate($this->attribute);
    }

    private function datetimeValidate()
    {
        $validator = new DateValidator();
        $validator->format = 'php:Y-m-d H:i';
        return $validator->validate($this->attribute);
    }
}