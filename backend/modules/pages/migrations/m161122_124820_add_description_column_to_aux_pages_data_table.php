<?php

namespace backend\modules\pages\migrations;

use yii\db\Migration;

/**
 * Handles adding description to table `aux_pages_data`.
 */
class m161122_124820_add_description_column_to_aux_pages_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('aux_pages_data', 'description', $this->string());
        $sql = <<< sql
UPDATE aux_pages_data 
LEFT JOIN aux_pages_langs ON aux_pages_langs.id=aux_pages_data.id
SET aux_pages_data.description=aux_pages_langs.description
WHERE aux_pages_langs.lang_id=2
sql;

        $this->execute($sql);

        $this->dropColumn('aux_pages_langs', 'description');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('aux_pages_data', 'description');
        $this->addColumn('aux_pages_langs', 'description', $this->string());
    }
}
