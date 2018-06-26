<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

class m170117_133209_add_fields_to_lot_dimensions_table extends Migration
{
    public function up()
    {
        $this->dropColumn('lot_dimensions', 'x_position');
        $this->dropColumn('lot_dimensions', 'y_position');
        $this->addColumn('lot_dimensions', 'row_num', $this->integer() . " comment 'номер строки'");
        $this->addColumn('lot_dimensions', 'col_count', $this->integer() . " comment 'кол-во столбцов(из 12)'");
        $this->addColumn('lot_dimensions', 'order_in_row', $this->integer() . " comment 'последовательность в строке'");
    }

    public function down()
    {
        $this->addColumn('lot_dimensions', 'x_position', $this->string());
        $this->addColumn('lot_dimensions', 'y_position', $this->string());
        $this->dropColumn('lot_dimensions', 'row_num');
        $this->dropColumn('lot_dimensions', 'col_count');
        $this->dropColumn('lot_dimensions', 'order_in_row');
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
