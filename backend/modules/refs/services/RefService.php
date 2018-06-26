<?php
/**
 * Created by IntelliJ IDEA.
 * User: Adlet
 * Date: 20.06.2016
 * Time: 11:48
 */

namespace backend\modules\refs\services;

use Yii;
use backend\modules\refs\models\MetaTable;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\data\SqlDataProvider;

class RefService extends Object
{
    public static function getColumns($table_name)
    {
        $table = self::findTable($table_name);
        foreach ($table->columnNames as $key => $column) {
            $column_values[] = $column;
        }
        return $table->columnNames;
    }


    public static function findTable($table_name)
    {
        $required_table = null;
        $connection = Yii::$app->db;
        $dbSchema = $connection->schema;
        $tables = $dbSchema->tableSchemas;
        foreach ($tables as $tbl) {
            if ($tbl->name == $table_name) {
                $required_table = $tbl;
            }
        }
        return $required_table;
    }

    public static function findModel($table_name, $prim_key = null)
    {
        /* @var $meta_model MetaTable */
        $meta_model = MetaTable::find()->where(['table_name' => $table_name])->one();
        if ($meta_model !== null) {
            /* @var $model ActiveRecord */
            $model = $meta_model->model_name;
            if (!empty($prim_key)) {
                $key = $model::find()->one()->tableSchema->primaryKey[0];
                if (($model = $model::find()->where([$key => $prim_key])->one()) !== null) {
                    return $model;
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            } else {
                return new $model;
            }

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public static function generateSqlCommands($table_name, $db = 'sql')
    {
        if ($db == 'sql') {
            $query = (new Query())->from($table_name);
            $sql = $query->createCommand()
                ->sql;
            $sqlDataProvider = new SqlDataProvider([
                'sql' => $sql
            ]);
            $all_commands = '';
            foreach ($sqlDataProvider->models as $model) {
                /** @noinspection SqlNoDataSourceInspection */
                $rrr = "INSERT INTO `" . $table_name . "` (";
                $cols = '';
                $vals = '';
                foreach ($model as $col => $val) {
                    $cols .= "`" . $col . "`, ";
                }
                $cols = substr(trim($cols), 0, -1);
                foreach ($model as $col => $val) {
                    if (!empty($val)) {
                        if ((int)$val == 0) {
                            $vals .= "'" . $val . "', ";
                        } else {
                            $vals .= $val . ',';
                        }
                    } else {
                        $vals .= 'NULL, ';
                    }
                }
                $vals = substr(trim($vals), 0, -1);
                $all_commands .= $rrr . $cols . ') VALUES (' . $vals . ');' . "\r\n";
            }
            return $all_commands;
        }
        return '';
    }

    public static function getPrimarykey($table_name)
    {
        $model = self::findModel($table_name);
        return $model->tableSchema->primaryKey[0];
    }

    public static function getTables()
    {
        $refs = MetaTable::find()->all();
        return ArrayHelper::map($refs, 'id', 'table_name');
    }
}