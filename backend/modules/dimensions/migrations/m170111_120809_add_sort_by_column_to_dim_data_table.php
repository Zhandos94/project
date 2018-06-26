<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles adding sort_by to table `dim_data`.
 */
class m170111_120809_add_sort_by_column_to_dim_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('dim_data', 'sort_by', $this->string()
            . " comment 'название поля, по которому будет сортироваться справочник' after ref_group_id");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('dim_data', 'sort_by');
    }
}
