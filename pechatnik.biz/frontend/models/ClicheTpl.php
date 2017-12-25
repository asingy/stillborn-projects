<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 13.11.17
 * Time: 19:41
 */

namespace frontend\models;


use frontend\models\query\ClicheTplQuery;

class ClicheTpl extends \backend\models\ClicheTpl
{
    public static function find()
    {
        return new ClicheTplQuery(get_called_class());
    }
}