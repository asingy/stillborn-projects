<?php

namespace backend\helpers;

use Yii;
use backend\models\ClicheSize;
use backend\models\ClicheStamp;
use backend\models\ClicheSizeStamp;
use backend\helpers\StampHelper;
use backend\helpers\ClichePriceHelper;
use yii\helpers\ArrayHelper;
class ClicheSizeHelper
{
  private static $statsName = [
    ClicheSize::STATUS_ACTIVE => 'Активен',
    ClicheSize::STATUS_INACTIVE => 'Не активен',
  ];

  public static function getAllStats()
  {
    return self::$statsName;
  }

  public static function getStatusName($status)
  {
    return self::$statsName[$status];
  }

  public static function getStatusLabels($status)
  {
    $labels = [
        ClicheSize::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        ClicheSize::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = ClicheSize::find()->where(['status'=>ClicheSize::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = ClicheSize::findOne($id);
    return $model->name;
  }

  public static function listByCliche($id_cliche)
  {
    // $sizes = ArrayHelper::getColumn(ClicheSizeStamp::find()->where(['id_cliche'=>$id_cliche])->all(), 'id_cliche_size');
    return ArrayHelper::map(ClicheSize::find()->where(['id_cliche' => $id_cliche])->all(), 'id', 'size');
  }

  public static function getSizes($id_cliche)
  {
    $sizes_list='';
    $sizes = ClicheSize::find()->where(['id_cliche' => $id_cliche])->all();
    foreach ($sizes as $key => $size) {
        $sizes_list .= '<option value="'.$size->id.'">'.$size->size.'</option>';
    }
    return $sizes_list;
  }

  public static function getSizesForOrder($id_cliche)
  {
    $sizes_list='';$first_size='';
    $sizes = ClicheSize::find()->where(['id_cliche' => $id_cliche])->all();
    foreach ($sizes as $key => $size) {
      if(ClichePriceHelper::checkPrice($id_cliche, $size->id)){
        if ($key == 0) {
          $first_size = $size->id;
        }
        $sizes_list .= '<option value="'.$size->id.'">'.$size->size.'</option>';
      }
    }

    $css= ArrayHelper::getColumn(ClicheSizeStamp::find()->where(['id_cliche_size' => $first_size])->all(), 'id_cliche_stamp');
    $stamps = StampHelper::getStampsForSelect($css);
    return ['sizes' => $sizes_list, 'stamps' => $stamps];
  }

  public static function getArraySizes($id_cliche)
  {
    return ArrayHelper::map(ClicheSize::find()->where(['id_cliche' => $id_cliche])->all(), 'id', 'size');
  }

}
