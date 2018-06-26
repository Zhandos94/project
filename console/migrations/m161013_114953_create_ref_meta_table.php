<?php

use yii\db\Migration;

/**
 * Handles the creation for table `ref_meta`.
 */
class m161013_114953_create_ref_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_meta', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(),
            'model_name' => $this->string(),
            'disabled' => $this->smallInteger(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
        ]);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $sql = <<< SQL
INSERT INTO `ref_meta` (`id`, `table_name`, `model_name`, `disabled`, `created_at`, `updated_at`, `updated_by`)
 VALUES (1, 'ref_doc_cats', 'common\\\models\\\\refs\\\RefDocCats', 0, NULL, NULL, NULL);
INSERT INTO `ref_meta` (`id`, `table_name`, `model_name`, `disabled`, `created_at`, `updated_at`, `updated_by`)
 VALUES (2, 'ref_doc_ext', 'common\\\models\\\\refs\\\RefDocExt', 0, NULL, NULL, NULL);
SQL;

        $this->execute($sql);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_meta');
    }
}
