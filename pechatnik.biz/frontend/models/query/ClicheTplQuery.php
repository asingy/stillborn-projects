<?php

namespace frontend\models\query;

use yii\db\ActiveQuery;

/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 13.11.17
 * Time: 19:42
 */
class ClicheTplQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere(['status'=>1]);
    }

}