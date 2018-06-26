<?php

use yii\db\Migration;

class m160902_093701_create_images_tables extends Migration
{
    public function up()
    {
        if (Yii::$app->db->getTableSchema('auc_images') === null) {
            $this->createTable('auc_images', [
                'id' => $this->primaryKey(),
                'auc_id' => $this->integer()->notNull(),
                'name' => $this->string(),
                'save_name' => $this->string()->notNull(),
                'general' => $this->smallInteger(1),
                'status' => $this->integer()->notNull()->defaultValue(0),
                'locked' => $this->smallInteger(1)->defaultValue(0),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ]);
        }

        if (Yii::$app->db->getTableSchema('auc_images_temp') === null) {
            $this->createTable('auc_images_temp', [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'save_name' => $this->string()->notNull(),
                'general_img' => $this->smallInteger(1),
                'hash' => $this->string()->notNull(),
            ]);
        }
    }

    public function down()
    {
        $this->dropTable('auc_images_temp');
        $this->dropTable('auc_images');
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
