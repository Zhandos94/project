<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

class m170131_134618_add_vis_condition_to_dim_data_table extends Migration
{
    public function up()
    {
        $this->addColumn('dim_data', 'vis_condition', $this->string());
    }

    public function down()
    {
        $this->dropColumn('dim_data', 'vis_condition');
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
