<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles adding in_filter to table `lot_dimensions`.
 */
class m170126_064335_add_in_filter_column_to_lot_dimensions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('lot_dimensions', 'in_filter', $this->smallInteger(1)->defaultValue(0)
            . " comment 'show dimension in filter' after lot_type_id");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('lot_dimensions', 'in_filter');
    }
}
