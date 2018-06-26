<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

class m170125_133842_add_field_to_dim_data_table extends Migration
{
    public function up()
    {
        $this->addColumn('dim_data', 'only_year', $this->smallInteger(1)->defaultValue(0) . " comment 'select only year' after with_time");
    }

    public function down()
    {
        $this->dropColumn('dim_data', 'only_year');
    }
}
