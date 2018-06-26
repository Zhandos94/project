<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `dim_visibility_settings`.
 */
class m170119_101533_create_dim_visibility_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dim_visibility_settings', [
            'parent_dim_id' => $this->integer(),
            'child_dim_id' => $this->integer(),
            'condition' => $this->string(),
            'disabled' => $this->smallInteger(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], "comment='таблица зависимости видимостей измерений'");

        $this->addPrimaryKey('primary key', 'dim_visibility_settings', ['parent_dim_id', 'child_dim_id']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dim_visibility_settings');
    }
}
