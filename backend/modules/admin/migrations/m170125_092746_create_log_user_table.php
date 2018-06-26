<?php
namespace backend\modules\admin\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `log_user`.
 */
class m170125_092746_create_log_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log_user', [
            'id' => $this->primaryKey(),
            'reason' => $this->string(),
            'id_user' => $this->integer(11),
            'id_status' => $this->smallInteger(),
            'date' => $this->dateTime(),
        ], 'ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log_user');
    }
}
