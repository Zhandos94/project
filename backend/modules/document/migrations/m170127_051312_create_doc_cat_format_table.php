<?php

namespace backend\modules\document\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `doc_cat_format`.
 */
class m170127_051312_create_doc_cat_format_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('doc_cat_format', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer(11),
            'for_id' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('doc_cat_format');
    }
}
