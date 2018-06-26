<?php
/**
 * Created by BADI.
 * DateTime: 05.01.2017 15:41
 */

namespace backend\modules\refs\services;


use backend\modules\refs\models\RefRelationsColumns;
use common\interfaces\Executable;

class SaveRelationService implements Executable
{

    const PARENT = 'parent';
    const CHILD = 'child';

    /* @var $relId integer */
    private $relId;

    /**
     * @param $relId integer
     */
    public function __construct($relId)
    {
        if (is_integer($relId)) {
            $this->relId = $relId;
        }
    }

    public function execute()
    {
        $relModel = new RefRelationsColumns();
        $relations = \Yii::$app->request->post($relModel->formName());
        $success = true;
        RefRelationsColumns::deleteAll(['relation_id' => $this->relId]);
        if ($relations !== null) {
            foreach ($relations as $relation) {
                $parentCol = trim($relation[self::PARENT]);
                $childCol = trim($relation[self::CHILD]);
                if (!empty($parentCol) && !empty($childCol)) {
                    if (RefRelationsColumns::find()->where(['relation_id' => $this->relId])
                            ->andWhere(['parent_column' => $parentCol])
                            ->andWhere(['child_column' => $childCol])
                            ->one() !== null
                    ) {
                        continue;
                    }
                    $model = new RefRelationsColumns();
                    $model->parent_column = $parentCol;
                    $model->child_column = $childCol;
                    $model->relation_id = $this->relId;
                    if (!$model->save()) {
                        $success = false;
                        \Yii::error($model->getErrors(), 'ref_relations');
                    }
                }
            }
        }
        return $success;
    }

}