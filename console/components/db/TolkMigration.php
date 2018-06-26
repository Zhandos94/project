<?php
/**
 * User: TOLK   created by IntelliJ IDEA.
 * Date: 21.01.2016 12:07
 */

namespace console\components\db;

use yii\db\Migration;

class TolkMigration extends Migration
{
    public function getTableOptions($tableComment = null) {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            if (!is_null($tableComment)) {
                $tableOptions = "COMMENT='$tableComment' ";
            }
            $tableOptions .= 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        return $tableOptions;
    }

}