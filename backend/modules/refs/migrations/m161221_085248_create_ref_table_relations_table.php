<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_table_relations`.
 */
class m161221_085248_create_ref_table_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_relations_table', [
            'id' => $this->primaryKey(),
            'parent_table_id' => $this->integer()->notNull() . " comment 'родительская таблица'",
            'child_table_id' => $this->integer()->notNull() . " comment 'дочерняя таблица'",
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_relations_table');
    }
}
