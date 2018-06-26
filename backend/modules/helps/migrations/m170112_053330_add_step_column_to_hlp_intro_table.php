<?php
namespace backend\modules\helps\migrations;
use yii\db\Migration;

/**
 * Handles adding step to table `hlp_intro`.
 */
class m170112_053330_add_step_column_to_hlp_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('hlp_intro', 'step', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('hlp_intro', 'step');
    }
}
