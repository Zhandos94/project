<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_columns_relations`.
 */
class m161221_085757_create_ref_columns_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_relations_columns', [
            'id' => $this->primaryKey(),
            'relation_id' => $this->integer()->notNull() . " comment 'ref_relations_table id'",
            'parent_column' => $this->string()->notNull() . " comment 'родительский столбец из родительской таблицы'",
            'child_column' => $this->string()->notNull() . " comment 'дочерний столбец из дочерней таблицы'",
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
        $this->dropTable('ref_relations_columns');
    }
}
