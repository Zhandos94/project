<?php

namespace backend\modules\admin\models;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * The function adds access data from table auth_assignment.
     * @param integer $user_id
     * @param array $item_name
     * @return mixed
     */
    public function writeAuthAssignment($user_id, $item_name)
    {

        if ($this->validate()) {
            foreach ($item_name as $key => $name) {
                foreach ($name as $item) {
                    $model = new AuthAssignment();
                    $model->item_name = trim($item);
                    $model->user_id = $user_id;
                    $model->created_at = time();
                    $model->save();

                }
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * The function returns data from table auth_item for appropriation.
     * @param string $id
     * @param array $params
     * @return array
     */
    public static function getArrayLeft($id, $params)
    {
        if ($id != null) {

            $model = AuthAssignment::find()
                ->select('item_name')
                ->where(['user_id' => $id])
                ->asArray()->all();

            $excludeItem =  [];
            foreach ($model as $subArr) {
                $excludeItem[] = $subArr['item_name'];
            }

            $leftArray = AuthItem::find()
                ->innerJoin('auth_type AS typ', '`typ`.`type` = `auth_item`.`type`')
                ->select(['typ.description', 'auth_item.name'])
                ->where(['NOT IN', 'auth_item.name', $excludeItem])
                ->andWhere(['NOT IN', 'auth_item.name', $params])
                ->asArray()->all();

            /*The array with key*/
            $keyArray = [];
            foreach ($leftArray as $data) {
                $keyArray[$data['description']][] = $data;
            }
            return $keyArray;
        }
        return '';
    }

    /**
     * The function returns the assigned data from table auth_item_child.
     * @param integer $id
     * @return array
     */
    public static function getArrayRight($id)
    {
        if ($id != null) {
            $rightArray = AuthAssignment::find()
                ->leftJoin('auth_item AS item', '`item`.`name` = `auth_assignment`.`item_name`')
                ->leftJoin('auth_type as typ', '`typ`.`type` = `item`.`type`')
                ->leftJoin('user as use', '`use`.`id` = `auth_assignment`.`user_id`')
                ->select(['typ.description', 'auth_assignment.item_name'])
                ->where(['=', 'use.id', $id])
                ->asArray()->all();

            /*The array with key*/
            $keyArray = [];
            foreach ($rightArray as $data) {
                $keyArray[$data['description']][] = $data;
            }

            return $keyArray;
        }
        return '';
    }
}
