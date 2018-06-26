<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles adding default_val to table `dim_data`.
 */
class m170126_122839_add_default_val_column_to_dim_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dim_data', 'default_val', $this->string() . " after type_id");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dim_data', 'default_val');
    }
}
