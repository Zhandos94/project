<?php

namespace backend\modules\pages\migrations;

use Yii;
use yii\db\Migration;

/**
 * Handles the creation for table `pages`.
 */
class m160908_054309_create_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        if (Yii::$app->db->getTableSchema('pages') === null) {
            $this->createTable('pages', [
                'code' => $this->string(40),
                'body' => $this->string(20000)->notNull(),
                'title' => $this->string(60)->notNull(),
                'description' => $this->string(),
                'is_public' => $this->smallInteger(1)->defaultValue(0),
            ]);
            $this->addPrimaryKey('pk_code', 'pages', 'code');
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('pages');
    }
}
