<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

class m170130_104309_add_index_to_dim_data_table extends Migration
{
    public function up()
    {
        $sql = <<< SQL
ALTER TABLE `dim_data`
	ADD UNIQUE INDEX `unique` (`code`);
SQL;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m170130_104309_add_index_to_dim_data_table cannot be reverted.\n";

        return false;
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
