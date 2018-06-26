<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `lot_dimensions`.
 */
class m161129_121042_create_lot_dimensions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lot_dimensions', [
            'dim_id' => $this->integer(),
            'lot_type_id' => $this->integer(),
            'x_position' => $this->string(),
            'y_position' => $this->string(),
        ]);
        $this->addPrimaryKey('primary key', 'lot_dimensions', ['dim_id', 'lot_type_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lot_dimensions');
    }
}
