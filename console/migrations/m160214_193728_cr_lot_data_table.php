<?php

use yii\db\Schema;
use console\components\db\TolkMigration;

class m160214_193728_cr_lot_data_table extends TolkMigration
{
    private $tablename = 'lot_data';
    private $tablecomment = 'Основная таблица для лотов';

    public function up()
    {

        $this->createTable('{{%'.$this->tablename.'}}', [
            'id' => $this->primaryKey(),
            'auc_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'user_id' => $this->integer()->notNull(),

            'addr_level1_id' => $this->integer()." comment 'Область/Город'",
            'addr_level2_id' => $this->integer()." comment 'Город/Район'",
            'addr_level3_id' => $this->integer()." comment 'Районный центр/Поселок/Аул/Район'",
            'addr_level4_id' => $this->integer()." comment 'Населенный пункт'",

            'other' => $this->string(400)." comment 'Прочее'",
            'condition' => $this->string(400)." comment 'Состояние'",

        ], $this->getTableOptions($this->tablecomment));
    }

    public function down()
    {
        $this->dropTable('{{%'.$this->tablename.'}}');
    }

}