<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `dim_data`.
 */
class m161129_103615_create_dim_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dim_data', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'name' => $this->string(500)->notNull(),
            'description' => $this->string(500),
            'visible_label' => $this->smallInteger(1)->defaultValue(1),
            'is_active' => $this->smallInteger(1)->defaultValue(1)->notNull(),
            'type_id' => $this->integer()->notNull() . ' comment "id of ref_dim_data_types"',
            'is_required' => $this->smallInteger(1)->defaultValue(0)->notNull(),
            'min_date' => $this->dateTime() . ' comment "не ранее чем"',
            'max_date' => $this->dateTime() . ' comment "не позднее чем"',
            'with_time' => $this->smallInteger(1)->defaultValue(0) . ' comment "date or dateTIME pickers"',
            'min_val' => $this->decimal(17, 5),
            'relation_min' => $this->string() . ' comment "отношение к min"',
            'max_val' => $this->decimal(17, 5),
            'relation_max' => $this->string() . ' comment "отношение к max"',
            'negative_allow' => $this->smallInteger(1)->defaultValue(0) . ' comment "Допустимость отрицательных чисел"',
            'decimal_sym_num' => $this->integer() . ' comment "Кол-во знаков после запятой"',
            'max_length' => $this->integer() . ' comment "Max кол-во символов"',
            'min_length' => $this->integer() . ' comment "Min кол-во символов"',
            'ref_id' => $this->integer() . " comment 'id of ref_meta'",
            'ref_group_id' => $this->integer() . " comment 'group_id of ref_dynamic_data'",
            'placeholder' => $this->string(),
            'group_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dim_data');
    }
}
