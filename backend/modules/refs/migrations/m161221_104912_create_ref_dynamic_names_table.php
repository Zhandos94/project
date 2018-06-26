<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_dynamic_names`.
 */
class m161221_104912_create_ref_dynamic_names_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_dynamic_table_name', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'disabled' => $this->smallInteger(1)->defaultValue(0),
        ]);

        $this->addCommentOnTable('ref_dynamic_table_name', 'таблица названий динамических справочников');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_dynamic_table_name');
    }
}
