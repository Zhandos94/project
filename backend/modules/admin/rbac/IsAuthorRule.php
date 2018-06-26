<?php
namespace backend\modules\admin\rbac;
use yii\rbac\Rule;
use Yii;
/**
 * Created by PhpStorm.
 * User: mrdos
 * Date: 13.01.2017
 * Time: 16:09
 */
class IsAuthorRule extends Rule
{
    public $name = 'isAuthorRule';
    public function execute($user, $item, $params)
    {
        if (!isset($params['dimData'])) {
            return false;
        }
        return ($params['dimData']->created_by == $user);
    }
}

