<?php

namespace backend\modules\document\migrations;

use yii\db\Migration;

class m170202_124053_change_colum_document_table extends Migration
{
    public function up()
    {
        $this->alterColumn('document', 'created_at',  $this->integer());
        $this->addColumn('document', 'updated_at',  $this->integer());
    }

    public function down()
    {
        $this->alterColumn('document', 'create_date',  $this->dateTime());
        $this->dropColumn('document', 'updated_at');

        return false;
    }


}
