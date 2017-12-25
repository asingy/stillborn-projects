<?php

namespace backend\helpers;

use Yii;
use backend\models\ReportAgent;
use backend\models\ReportSystem;
use yii\helpers\ArrayHelper;
class ReportHelper
{

  public static function getPageTotal($provider, $fieldName)
  {
    $total=0;
    foreach($provider as $item){
        $total+=$item[$fieldName];
    }
    return $total !== 0 ? $total. ' p.' : '';
  }

}
