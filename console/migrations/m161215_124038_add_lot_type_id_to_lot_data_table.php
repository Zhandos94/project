<?php

use yii\db\Migration;

class m161215_124038_add_lot_type_id_to_lot_data_table extends Migration
{
    public function up()
    {
        $this->addColumn('lot_data', 'lot_type_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('lot_data', 'lot_type_id');
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
