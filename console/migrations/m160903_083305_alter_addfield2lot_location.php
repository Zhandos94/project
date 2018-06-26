<?php

use console\components\db\TolkMigration;

class m160903_083305_alter_addfield2lot_location extends TolkMigration
{
    private $tablename = 'lot_data';

    public function up()
    {
        $this->addColumn('{{%'.$this->tablename.'}}', 'location', $this->string(500)->notNull().' COMMENT " Местонахождение лота"');
    }

    public function down()
    {
        $this->dropColumn('{{%'.$this->tablename.'}}', 'location');
    }

}