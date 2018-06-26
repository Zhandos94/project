<?php

namespace backend\modules\admin\migrations;
use yii\db\Migration;

class m170111_165527_create_auth_type extends Migration
{
    public function up()
    {
        $this->createTable('auth_type', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(11),
            'description' => $this->string(85),
        ], 'ENGINE=InnoDB');

        $this->insert('auth_type',array(
            'type' =>1,
            'description' => 'Role',
        ));
        $this->insert('auth_type',array(
            'type' =>2,
            'description' => 'Permission',
        ));

    }

    public function down()
    {

        $this->dropTable('auth_type');

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
