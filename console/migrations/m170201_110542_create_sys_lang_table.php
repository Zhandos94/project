<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sys_lang`.
 */
class m170201_110542_create_sys_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $sql = <<< SQL
CREATE TABLE IF NOT EXISTS `sys_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `default` smallint(6) NOT NULL DEFAULT '0',
  `date_update` int(11) NOT NULL,
  `date_create` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы common.sys_lang: ~4 rows (приблизительно)
DELETE FROM `sys_lang`;
/*!40000 ALTER TABLE `sys_lang` DISABLE KEYS */;
INSERT INTO `sys_lang` (`id`, `url`, `local`, `name`, `default`, `date_update`, `date_create`) VALUES
	(1, 'kz', 'kz-KZ', 'Қазақша', 0, 1479181902, 1479181902),
	(2, 'ru', 'ru-RU', 'Русский', 1, 1479181902, 1479181902),
	(3, 'en', 'en-EN', 'English', 0, 1479181902, 1479181902),
	(4, 'tt', 'tt-RU', 'Test', 0, 1479181902, 1479181902);
/*!40000 ALTER TABLE `sys_lang` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
SQL;

        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sys_lang');
    }
}
