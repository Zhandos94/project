<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

/**
 * Handles adding description to table `ref_meta`.
 */
class m161207_123103_add_description_column_to_ref_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('ref_meta', 'description', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('ref_meta', 'description');
    }
}
