<?php

use yii\db\Migration;

class m160902_065431_create_auc_data extends Migration
{
    public function up()
    {
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $sql = <<< SQL
CREATE TABLE `auc_data` (
 `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ид',
 `source_auc_id` INT(11) NULL DEFAULT NULL COMMENT 'Номер исходного объявления',
 `number_anno` VARCHAR(20) NOT NULL COMMENT 'Номер объявления',
 `cruser_id` INT(11) NOT NULL COMMENT 'Пользователь-автор',
 `org_id` INT(11) NULL DEFAULT NULL COMMENT 'id организатора',
 `subject_id` INT(11) NOT NULL COMMENT 'id заказчика',
 `lienor_id` INT(11) NULL DEFAULT NULL COMMENT 'Залогодержатель',
 `agent_id` INT(11) NULL DEFAULT NULL COMMENT 'Доверенное лицо',
 `agent_phone` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Телефон доверенного лица',
 `agent_email` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Электронная почта доверенного лица',
 `agent_address` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Адрес доверенного лица',
 `pledgor` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Залогодатель',
 `payment_details` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Платежные Реквизиты',
 `margin_pay_cond` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Условия оплаты гарантийного взноса',
 `notifications` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Направленные уведомления и отметки о получении',
 `media_public` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Публикация в СМИ',
 `colcat_id` INT(11) NOT NULL COMMENT 'Тип имущества',
 `start_date` DATETIME NULL DEFAULT NULL COMMENT 'дата начала',
 `end_date` DATETIME NULL DEFAULT NULL COMMENT 'дата завершения',
 `buy_status` INT(11) NOT NULL COMMENT 'Статус объявления',
 `title_ru` VARCHAR(255) NOT NULL COMMENT 'Заголовок объявления',
 `title_kz` VARCHAR(255) NOT NULL COMMENT 'Заголовок объявления',
 `name_ru` TEXT NOT NULL COMMENT 'Текст объявления на русском',
 `name_kz` TEXT NOT NULL COMMENT 'Текст объявления на казахском',
 `sale_type` TINYINT(2) NOT NULL COMMENT 'Вид реализации',
 `auction_type` TINYINT(2) NULL DEFAULT NULL COMMENT 'Тип аукциона',
 `lastupdateuserid` INT(11) NULL DEFAULT NULL COMMENT 'id пользователя, последнего производившего изменения',
 `lastupdate` DATETIME NULL DEFAULT NULL COMMENT 'дата обновления',
 `count_lots` INT(11) NOT NULL COMMENT 'количество лотов в объявлении',
 `start_sum` DECIMAL(20,2) NOT NULL COMMENT 'Начальная сумма',
 `margin_sum` DECIMAL(20,2) NOT NULL COMMENT 'Сумма гарантийного взноса',
 `reserve_price` DECIMAL(20,2) NULL DEFAULT NULL COMMENT 'Резервная цена - сумма минимальная при Голландском методе',
 `increment` DECIMAL(20,2) NULL DEFAULT NULL COMMENT 'Шаг аукциона',
 `imgname` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
 `imgsavename` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
 `venue` VARCHAR(255) NOT NULL COMMENT 'Место проведения торгов',
 `region_id` INT(11) NULL DEFAULT NULL COMMENT 'Регион (область)',
 `is_collateral` SMALLINT(1) NULL DEFAULT NULL COMMENT 'Признак залога',
 `apa_end_datetime` DATETIME NULL DEFAULT NULL COMMENT 'Дата/время окончания приема заявки на участие',
 `is_direct_sale` SMALLINT(1) NULL DEFAULT NULL COMMENT 'Собственная продажа',
 `is_operator_ads` SMALLINT(1) NULL DEFAULT NULL COMMENT 'Объявления MITWORK',
 PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
SQL;
        $this->execute($sql);
        return true;
    }

    public function down()
    {
        echo "m160902_065431_create_auc_data cannot be reverted.\n";

        return true;
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
