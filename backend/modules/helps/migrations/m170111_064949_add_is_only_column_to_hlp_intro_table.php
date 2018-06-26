<?php
namespace backend\modules\helps\migrations;
use yii\db\Migration;

/**
 * Handles adding is_only to table `hlp_intro`.
 */
class m170111_064949_add_is_only_column_to_hlp_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hlp_intro', 'is_only', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('hlp_intro', 'is_main', $this->smallInteger(1)->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hlp_intro', 'is_only');
        $this->dropColumn('hlp_intro', 'is_main');
    }
}
