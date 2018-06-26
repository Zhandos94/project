<?php

namespace backend\modules\pages\migrations;

use yii\db\Migration;

class m161115_061451_add_columns_to_pages_langs_table extends Migration
{
    public function up()
    {
        $this->addColumn('aux_pages_langs', 'created_by', $this->integer());
        $this->addColumn('aux_pages_langs', 'updated_by', $this->integer());
        $this->addColumn('aux_pages_langs', 'created_at', $this->dateTime() . ' DEFAULT CURRENT_TIMESTAMP');
        $this->addColumn('aux_pages_langs', 'updated_at', $this->dateTime() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->dropColumn('aux_pages_langs', 'created_by');
        $this->dropColumn('aux_pages_langs', 'updated_by');
        $this->dropColumn('aux_pages_langs', 'created_at');
        $this->dropColumn('aux_pages_langs', 'updated_at');
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
