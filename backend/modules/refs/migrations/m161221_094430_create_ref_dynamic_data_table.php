<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_dynamic_data`.
 */
class m161221_094430_create_ref_dynamic_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_dynamic_table_data', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull() . " comment 'группировка в одну таблицу'",
            'name_ru' => $this->string(),
            'name_kz' => $this->string(),
            'disabled' => $this->smallInteger(1)->defaultValue(0),
        ]);
        $this->addCommentOnTable('ref_dynamic_table_data', 'таблица данных динамических справочников');

        $sql = <<<sql
INSERT INTO `ref_meta` (`id`,`table_name`, `model_name`, `disabled`, `created_at`, `updated_at`, `updated_by`, `description`)
 VALUES (-1,'ref_dynamic_table_data', 'backend\\\modules\\\\refs\\\models\\\RefDynamicTableData', 0, NULL, NULL, NULL, NULL);
sql;

        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_dynamic_table_data');
    }
}
