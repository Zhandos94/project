<?php

namespace backend\modules\admin\models;

use Yii;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'exist', 'skipOnError' => true,
                'targetClass' => AuthItem::className(),
                'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true,
                'targetClass' => AuthItem::className(),
                'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }

    /**
     * This is function adds data in table auth_item_child.
     * @param string $parent
     * @param array $children
     * @return mixed
     */
    public function writeItemChild($parent, $children){

        if($this->validate()){
            foreach ($children as $key => $child) {
                foreach ($child as $item) {
                    $model = new AuthItemChild();
                    $model->parent = $parent;
                    $model->child = trim($item);
                    $model->save();
                }
            }
            return true;
        }
        return false;
    }

}
