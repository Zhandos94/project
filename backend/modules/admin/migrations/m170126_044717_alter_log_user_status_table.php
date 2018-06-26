<?php
namespace backend\modules\admin\migrations;

use yii\db\Migration;

class m170126_044717_alter_log_user_status_table extends Migration
{
    public function up()
    {
        $this->addColumn('log_user_status',
            'name', $this->string(32));

        $this->update('log_user_status',
            ['name' => 'Disabled'], ['id'=>1] );

        $this->update('log_user_status',
            ['name' => 'Active'], ['id'=>2] );

        $this->update('log_user_status',
            ['name' => 'Created'], ['id'=>3] );

        $this->update('log_user_status',
            ['name' => 'Changed password'], ['id'=>4]);

        $this->update('log_user_status',
            ['name' => 'Forgot password'], ['id'=>5] );
        $this->execute('');
    }

    public function down()
    {
        $this->dropColumn('log_user_status', 'name');

        $this->delete('log_user_status', ['id' => 1]);
        $this->delete('log_user_status', ['id' => 2]);
        $this->delete('log_user_status', ['id' => 3]);
        $this->delete('log_user_status', ['id' => 4]);
        $this->delete('log_user_status', ['id' => 5]);
    }
}
