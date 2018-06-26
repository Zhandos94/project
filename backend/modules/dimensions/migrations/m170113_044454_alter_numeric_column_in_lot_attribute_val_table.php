<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

class m170113_044454_alter_numeric_column_in_lot_attribute_val_table extends Migration
{
    public function up()
    {
        $this->alterColumn('lot_attribute_val', 'numeric', $this->decimal(17, 6));
    }

    public function down()
    {
        $this->alterColumn('lot_attribute_val', 'numeric', $this->float());
    }
}
