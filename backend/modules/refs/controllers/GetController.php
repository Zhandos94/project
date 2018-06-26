<?php

namespace backend\modules\refs\controllers;

use backend\modules\refs\services\RelationService;
use common\models\refs\RefKato;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * RefsController get references.
 */
class GetController extends Controller
{
    /**
     * List of KATO Level2
     * @param $q
     * @return mixed
     */
    public function actionKl2($q = null)
    {
        if ($q !== null) {
        }
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $level1_id = $parents[0];
                $out = self::getKATOLvl2_list($level1_id);

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => $out, 'selected' => '']);
        return;
    }

    /**
     * List of KATO Level2
     * @param $q
     * @return mixed
     */
    public function actionKl3($q = null)
    {
        if ($q !== null) {
        }
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $level2_id = $parents[0];
                $out = self::getKATOLvl3_list($level2_id);

                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => $out, 'selected' => '']);
        return;
    }

    private function getKATOLvl2_list($parent_te)
    {
        if ($parent_te != null) {
            if (($parent_te == '750000000') ||   //Almaty TODO convert to other conditions
                ($parent_te == '710000000')
            ) {  //Astana
                $kato = RefKato::find()
                    ->leftJoin('ref_kato AS parent', '`parent`.`ab` = `ref_kato`.`ab`')
                    ->where(['parent.te' => $parent_te])
                    ->andWhere(['!=', 'ref_kato.cd', '00'])
                    ->andWhere(['!=', 'ref_kato.ef', '00'])
                    ->select(['ref_kato.te AS id', 'ref_kato.name_ru AS name'])
                    ->limit(50)->asArray()->all();
                return $kato;
            } else {
                $kato = RefKato::find()
                    ->leftJoin('ref_kato AS parent', '`parent`.`ab` = `ref_kato`.`ab`')
                    ->where(['parent.te' => $parent_te, 'ref_kato.ef' => '00'])
                    ->andWhere(['!=', 'ref_kato.cd', '00'])
                    ->andWhere(['=', 'ref_kato.hij', '000'])//TODO conflict - hidden 4level child for 2level
                    ->select(['ref_kato.te AS id', 'ref_kato.name_ru AS name'])
                    ->limit(50)->asArray()->all();
                return $kato;
            }
        }
        return ''; //TODO check if ab is null variant
    }

    private function getKATOLvl3_list($parent_te)
    {
        if ($parent_te != null) {
            $kato = RefKato::find()
                ->leftJoin('ref_kato AS parent', '`parent`.`ab` = `ref_kato`.`ab` and `parent`.`cd` = `ref_kato`.`cd`')
                ->where(['parent.te' => $parent_te, 'ref_kato.hij' => '000'])
                ->andWhere(['!=', 'ref_kato.ef', '00'])
                ->andWhere(['!=', 'ref_kato.te', $parent_te])
                ->select(['ref_kato.te AS id', 'ref_kato.name_ru AS name'])
                ->limit(50)->asArray()->all();
            return $kato;
        }
        return ''; //TODO check if ab is null variant
    }

    /**
     * @param $id integer id of table
     * @return string columns list of table
    */
    public function actionColumns($id)
    {
        $relService = new RelationService();
        $usableList = $relService->getColumnList($id);
        return json_encode($usableList);
    }
}
