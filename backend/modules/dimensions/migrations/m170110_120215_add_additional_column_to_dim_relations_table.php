<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles adding additional to table `dim_relations`.
 */
class m170110_120215_add_additional_column_to_dim_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dim_relations', 'extra_toggle', $this->smallInteger(1)->defaultValue(0)
            . " comment 'дополнительный костыль, например для като 2-го уровня'");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dim_relations', 'extra_toggle');
    }
}
