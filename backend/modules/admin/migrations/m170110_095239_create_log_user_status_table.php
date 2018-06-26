<?php
namespace backend\modules\admin\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `log_user_status`.
 */
class m170110_095239_create_log_user_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log_user_status', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(11),
            'description' => $this->string(85),
        ], 'ENGINE=InnoDB');

        $this->insert('log_user_status',array(
            'status' =>0,
            'description' => 'User is blocked',
        ));
        $this->insert('log_user_status',array(
            'status' =>10,
            'description' => 'User is active',
        ));
        $this->insert('log_user_status',array(
            'status' =>20,
            'description' => 'User created',
        ));
        $this->insert('log_user_status',array(
            'status' =>30,
            'description' => 'User changed password',
        ));
        $this->insert('log_user_status',array(
            'status' =>40,
            'description' => 'User forgot password',
        ));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log_user_status');
    }
}
