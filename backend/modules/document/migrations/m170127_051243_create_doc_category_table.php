<?php

namespace backend\modules\document\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `doc_category`.
 */
class m170127_051243_create_doc_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('doc_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(62),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('doc_category');
    }
}
