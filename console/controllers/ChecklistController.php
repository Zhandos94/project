<?php
/**
 * User: TOLK   created by IntelliJ IDEA.
 * Date: 11.02.2016 12:18
 */
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * @property string info
 * @property string warning
 */
class ChecklistController extends Controller
{

    const DT_FORMAT = 'Y-m-d H:i:s';
    private $infoTxt;
    private $warnTxt;
    private $warncount = 0;
    private /** @noinspection PhpUnusedPrivateFieldInspection */
        $errorTxt;

    public function actionIndex()
    {
        //error_reporting(E_ALL ^ E_NOTICE);

        //example colorize:
        //$name = $this->ansiFormat('TOLK', Console::BG_GREEN, Console::FG_YELLOW);
        //echo "Hello, my name is $name.";

        $startTime = time();
        echo "checklist STARTed, on " . date(self::DT_FORMAT, $startTime)
            . "\t\t\tCurrent PHP version: " . phpversion();
        //echo var_dump(Yii::$app);

        $this->iniCheck(true);
        $this->actionComments();

        $this->dimensionsCheck();

//        $this->yiiCheck();

        if ($this->hasWarning()) {
            echo "\nChecklist has WARNING!!!";
            echo $this->warnTxt . "\n";
        }

        echo $this->infoTxt;
    }

    private function yiiCheck(/*$detail = false*/)
    {
        $this->info = 'Host info - ' . Yii::$app->urlManager->hostInfo
            . "\t\tBase url - " . @Yii::$app->urlManager->baseUrl;
    }

    private function iniCheck($detail = false)
    {
        if ($detail) {
            $iniPath = php_ini_loaded_file();
            $this->info = "Ini file - {$iniPath}";
        }


        $iniTimezone = ini_get('date.timezone');
        if ($iniTimezone == '') {
            $this->warning = 'Timezone in ini file is blank, some packages set wrong if blank value(eg. MPDF)';
        } else {
            $this->info = "Timezone in ini file - {$iniTimezone}";
        }

        if ($detail) {
            $iniErrReporting = ini_get('error_reporting');
            $this->info = "Error reporting in ini file - {$iniErrReporting}";
        }

        $this->info = "";
    }

    private function hasWarning()
    {
        return trim($this->warnTxt) != '';
    }

    protected function setWarning($str)
    {
        $this->warncount++;
        $this->warnTxt .= "\n$this->warncount) $str";
    }

    protected function setInfo($str)
    {
        $this->infoTxt .= "\n$str";
    }

    public function actionComments()
    {
        if (!file_exists(Yii::getAlias('frontend') . '/web/js/translate/message.js')) {
            $this->warnTxt = 'file not exist, filepath: ' . Yii::getAlias('frontend') . '/web/js/translate/message.js';
//            echo 'file not exist, filepath: ' . Yii::getAlias('frontend').'/web/js/translate/message.js';
        }

        $tableName = 'message1';
        $table = Yii::$app->db->createCommand("show tables like '$tableName'")->queryOne();
        if ($table === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName";
        }

        $column = Yii::$app->db->createCommand('select id from message where id=433334')->queryOne();
        if ($column === false) {
            $this->warnTxt .= "\n record is not exist";
        }


    }

    private function dimensionsCheck()
    {
        $backWeb = Yii::getAlias('backend') . '/web';
        $backWebDims = $backWeb . '/js/dimensions';
        $frontWeb = Yii::getAlias('frontend') . '/web';
        $frontWebDims = $frontWeb . '/js/dimensions';
        if (!file_exists($backWebDims)) {
            $this->warnTxt .= "\n create folder $backWebDims";
        }
        if (!file_exists($backWebDims . '/cr_attributes.js')) {
            $this->warnTxt .= "\n js file is not exist, filepath: " . $backWebDims . '/cr_attributes.js';
        }

        if (!file_exists($backWeb . '/js/dynamic_form.js')) {
            $this->warnTxt .= "\n js file is not exist, filepath: " . $backWeb . '/js/dynamic_form.js';
        }

        if (!file_exists($frontWebDims)) {
            $this->warnTxt .= "\n create folder $frontWebDims";
        }

        if (!file_exists($frontWebDims . '/baseValidate.js')) {
            $this->warnTxt .= "\n js file is not exist, filepath: " . $frontWebDims . '/baseValidate.js';
        }

        $tableName1 = 'lot_attribute_val';
        $table1 = Yii::$app->db->createCommand("show tables like '$tableName1'")->queryOne();
        if ($table1 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName1";
        }

        $tableName2 = 'dim_data';
        $table2 = Yii::$app->db->createCommand("show tables like '$tableName2'")->queryOne();
        if ($table2 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName2";
        }

        $tableName3 = 'lot_dimensions';
        $table3 = Yii::$app->db->createCommand("show tables like '$tableName3'")->queryOne();
        if ($table3 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName3";
        }

        $tableName4 = 'ref_lot_types';
        $table4 = Yii::$app->db->createCommand("show tables like '$tableName4'")->queryOne();
        if ($table4 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName4";
        }

        $tableName5 = 'ref_dim_data_types';
        $table5 = Yii::$app->db->createCommand("show tables like '$tableName5'")->queryOne();
        if ($table5 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName5";
        }

        $tableName6 = 'ref_dynamic_table_name';
        $table6 = Yii::$app->db->createCommand("show tables like '$tableName6'")->queryOne();
        if ($table6 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName6";
        }

        $tableName7 = 'ref_dynamic_table_data';
        $table7 = Yii::$app->db->createCommand("show tables like '$tableName7'")->queryOne();
        if ($table7 === false) {
            $this->warnTxt .= "\n table not exist, tablename: $tableName7";
        }

        $column = Yii::$app->db->createCommand('select id from ref_meta where id=-1')->queryOne();
        if ($column === false) {
            $this->warnTxt .= "\n in ref_meta not find row with id = -1";
        }
    }
}