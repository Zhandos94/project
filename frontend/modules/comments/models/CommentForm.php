<?php

namespace frontend\modules\comments\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 *
 * @property string $name
 * @property string $body
 * @property integer $group_id
 * @property integer $global_group_id
 * @property integer $parent_id
 */
class CommentForm extends Model
{
	public $name;
	public $body;
	public $group_id;
	public $global_group_id;
	public $parent_id;
	public $verifyCode;

	public function rules()
	{
		$rules = [
			[['name'], 'string', 'max' => 30],
			[['group_id', 'global_group_id', 'parent_id'], 'integer'],
			[['body'], 'trim'],
			[['body'], 'string', 'min' => 2, 'max' => 255],
			['body', 'required'],
			// [['name'], 'required', 'when' => function () {
			// 		if (!$this->name && Yii::$app->user->isGuest) {
			// 			$this->addError('name', Yii::t('app', 'you must enter nickname'));
			// 		}
			// 	},
			// 	'whenClient' => 'function (attribute, value) { return !$(\'#commentform-name\').val().length;}',
			// 	'message' => Yii::t('app', 'you must enter nickname')
			// ],
		];
		if (Yii::$app->user->isGuest) {
			array_push($rules, ['verifyCode', 'captcha', 'captchaAction'=>'/comments/default/captcha']);
		}
		return $rules;
	}
}
