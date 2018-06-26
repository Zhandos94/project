<?php

namespace backend\modules\dimensions\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `ref_lot_types`.
 */
class m161129_121634_create_ref_lot_types_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ref_lot_types', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name_ru' => $this->string(),
            'name_kz' => $this->string(),
            'disabled' => $this->smallInteger(1)->defaultValue(0),
        ]);

        $sql = <<<SQL
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (1, 'auto', 'Автотранспорт', 'Автокөлік', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (2, 'house', 'Жилой дом', 'Үй', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (3, 'land', 'Земельный участок', 'Жер телімі', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (4, 'apart', 'Квартира', 'Пәтер', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (5, 'ind_estate', 'Недвижимость производственного/коммерческого назначения', 'Жылжымайтын мүлік өнеркәсіптік / коммерциялық', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (6, 'uncmpconst', 'Незавершенное строительство', 'Аяқталмаған құрылыс', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (7, 'equipment', 'Оборудование', 'Жабдық', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (8, 'spec_equp', 'Спецтехника', 'Арнайы жабдық', 0);
INSERT INTO `ref_lot_types` (`id`, `code`, `name_ru`, `name_kz`, `disabled`)
VALUES (9, 'goods', 'Товар в обороте', 'Айналыстағы тауарлар', 0);
SQL;
        $this->execute($sql);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ref_lot_types');
    }
}
