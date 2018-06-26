<?php

namespace backend\modules\document\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `documents`.
 */
class m170127_051218_create_documents_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer(11)->notNull(),
            'com_id' => $this->integer(11),
            'sign_status' => $this->smallInteger()->defaultValue(0),
            'name' => $this->string(65),
            'save_name' => $this->string(255),
            'create_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('document');
    }
}
