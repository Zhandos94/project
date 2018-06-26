<?php

namespace backend\modules\admin\models;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthType()
    {
        return $this->hasOne(AuthType::className(), ['type' => 'type']);
    }

    public static function  getExistsRole($roleName)
    {
        $model = AuthItem::find()->select('name')
                ->where(['name' => $roleName])
                ->asArray()
                ->one();

        return $model['name'];
    }

    /**
     * The function get the role name.
     * @param  string $id
     * @return mixed
     */
    public static function getListRole($id)
    {
        $model = AuthAssignment::find()
            ->where(['item_name' => $id]);

        return $model;
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

            $child = AuthItemChild::find()->select('child')->where(['parent' => $id])->asArray()->all();
            $childOut = array();
            foreach ($child as $subArr) {
                $childOut[] = $subArr['child'];
            }

            $leftArray = AuthItem::find()
                ->innerJoin('auth_type AS typ', '`typ`.`type` = `auth_item`.`type`')
                ->select(['typ.description', 'auth_item.name'])
                ->where(['NOT IN', 'auth_item.name', $childOut])
                ->andWhere(['NOT IN', 'auth_item.name', $params])
                ->andWhere(['!=', 'auth_item.name', $id])
                ->asArray()->all();

            $keyArray = [];
            foreach ($leftArray as $data) {
                $keyArray[$data['description']][] = $data;
            }
            return $keyArray;
        }
        return ''; //TODO your variant
    }

    /**
     * The function returns the assigned data from table auth_item_child.
     * @param string $id
     * @return array
     */
    public static function getArrayRight($id)
    {
        if ($id != null) {
            $rightArray = AuthItem::find()
                ->innerJoin('auth_type AS typ', '`typ`.`type` = `auth_item`.`type`')
                ->leftJoin('auth_item_child as child', '`child`.`child` = `auth_item`.`name`')
                ->select(['typ.description', 'auth_item.name'])
                ->where(['=', 'child.parent', $id])
                ->asArray()->all();

            $keyArray = [];
            foreach ($rightArray as $data) {
                $keyArray[$data['description']][] = $data;
            }

            return $keyArray;
        }
        return ''; //TODO your variant
    }

    /**
     * The function adds route data into table auth_item.
     * @param array $names
     * @return mixed
     */
    public function writeRoute($names)
    {
        if ($this->validate()) {
            foreach ($names['key'] as $name) {
                $model = new AuthItem();
                $model->name = $name;
                $model->type = 3;
                $model->created_at = time();
                $model->updated_at = time();
                $model->save();
            }
            return true;
        }
        return false;
    }
}
