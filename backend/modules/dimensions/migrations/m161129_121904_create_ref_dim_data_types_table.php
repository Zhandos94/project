<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_data_types`.
 */
class m161129_121904_create_ref_dim_data_types_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_dim_data_types', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name_ru' => $this->string(),
            'name_kz' => $this->string(),
            'disabled' => $this->smallInteger(1)->defaultValue(0),
        ]);


        $sql = <<<SQL
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (1, 'checkbox', 'CheckBox', NULL, 0);
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (2, 'string', 'текстовый', NULL, 0);
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (3, 'numeric', 'числовой', NULL, 0);
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (4, 'datetime', 'дата', NULL, 0);
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (5, 'ref', 'справочник', NULL, 0);
INSERT INTO `ref_dim_data_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (6, 'text', 'просто текст', NULL, 0);
SQL;
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_dim_data_types');
    }
}
