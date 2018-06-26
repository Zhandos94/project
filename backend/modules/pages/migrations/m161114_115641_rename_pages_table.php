<?php

namespace backend\modules\pages\migrations;

use yii\db\Migration;

class m161114_115641_rename_pages_table extends Migration
{
    public function up()
    {
        $this->renameTable('pages', 'aux_pages');
    }

    public function down()
    {
        $this->renameTable('aux_pages','pages');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
