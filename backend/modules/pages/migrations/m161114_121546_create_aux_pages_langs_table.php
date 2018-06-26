<?php

namespace backend\modules\pages\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `aux_pages_langs`.
 */
class m161114_121546_create_aux_pages_langs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aux_pages_langs', [
            'id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'body' => $this->string(20000)->notNull(),
            'title' => $this->string(60)->notNull(),
            'description' => $this->string(),
        ]);
        $this->addPrimaryKey('primary key', 'aux_pages_langs', ['id', 'lang_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aux_pages_langs');
    }
}
