<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `dim_relations`.
 */
class m170109_033152_create_dim_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dim_relations', [
            'parent_dim_id' => $this->integer(),
            'child_dim_id' => $this->integer(),
            'condition' => $this->string(),
            'disabled' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addPrimaryKey('primary key', 'dim_relations', ['parent_dim_id', 'child_dim_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dim_relations');
    }
}
