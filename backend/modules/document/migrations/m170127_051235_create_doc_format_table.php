<?php

namespace backend\modules\document\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `doc_format`.
 */
class m170127_051235_create_doc_format_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('doc_format', [
            'id' => $this->primaryKey(),
            'name' => $this->string(62),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('doc_format');
    }
}
