<?php

namespace backend\modules\pages\migrations;

use yii\db\Migration;

class m161114_122502_alter_aux_pages_table extends Migration
{
    public function up()
    {
        $sql = <<< sql
ALTER TABLE aux_pages ADD id INT NOT NULL AUTO_INCREMENT FIRST, DROP PRIMARY KEY, ADD PRIMARY KEY (id);

INSERT INTO aux_pages_langs (
SELECT id, 2 lang_id, body, title, description
FROM aux_pages 
);

ALTER TABLE aux_pages DROP body, DROP title, DROP description;

RENAME TABLE aux_pages TO aux_pages_data;
sql;
        $this->execute($sql);




    }

    public function down()
    {
        echo "m161114_122502_alter_aux_pages_table cannot be reverted.\n";

        return false;
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
