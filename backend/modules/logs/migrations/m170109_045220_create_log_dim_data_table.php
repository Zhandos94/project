<?php
namespace  backend\modules\logs\migrations;
use yii\db\Migration;

/**
 * Handles the creation of table `log_dim_data`.
 */
class m170109_045220_create_log_dim_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('log_dim_data', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'action' => $this->string(16)->notNull(),
            'dim_id' => $this->integer()->notNull(),
            'date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('log_dim_data');
    }
}
