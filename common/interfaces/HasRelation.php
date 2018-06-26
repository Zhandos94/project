<?php
/**
 * Created by BADI.
 * DateTime: 09.01.2017 19:10
 */

namespace common\interfaces;


interface HasRelation
{
    public function getNameColumn();

    public function getIdColumn();
}