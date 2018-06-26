<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `lot_attributes_vals`.
 */
class m161129_102611_create_lot_attributes_vals_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lot_attribute_val', [
            'id' => $this->primaryKey(),
            'lot_id' => $this->integer()->defaultValue(0).' comment "id лота"',
            'auc_id' => $this->integer().' comment "id аукциона"',
            'lot_type_id' => $this->integer().' comment "id типа лота"',
            'dim_id' => $this->integer().' comment "id атрибута"',
            'text' => $this->string(),
            'numeric' => $this->float(),
            'date' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lot_attribute_val');
    }
}
