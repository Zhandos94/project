<?php

namespace backend\modules\refs\migrations;

use yii\db\Migration;

class m170112_105041_insert_refs_to_ref_meta extends Migration
{
    public function up()
    {
        $sql = <<< SQL
INSERT INTO `ref_meta` (`table_name`, `model_name`, `disabled`, `created_at`, `updated_at`, `updated_by`, `description`)
 VALUES ('ref_kato', 'common\\\models\\\\refs\\\RefKato', 0, NULL, NULL, NULL, NULL);
INSERT INTO `ref_meta` (`table_name`, `model_name`, `disabled`, `created_at`, `updated_at`, `updated_by`, `description`)
 VALUES ('ref_countries', 'common\\\models\\\\refs\\\RefCountries', 0, NULL, NULL, NULL, 'Страны');

SQL;

        $this->execute($sql);
    }

    public function down()
    {
        echo "m170112_105041_insert_refs_to_ref_meta cannot be reverted.\n";

//        return false;
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
