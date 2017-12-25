<?php

namespace backend\helpers;

use Yii;
use backend\models\Stamp;
use backend\models\ClicheStamp;
use backend\models\ClicheSizeStamp;
use backend\helpers\StampPriceHelper;
use yii\helpers\ArrayHelper;
class StampHelper
{
  private static $stats_name = [
    Stamp::STATUS_ACTIVE => 'Активен',
    Stamp::STATUS_INACTIVE => 'Не активен',
  ];

  public static function getAllStats()
  {
    return self::$stats_name;
  }

  public static function getStatusName($status)
  {
    return self::$stats_name[$status];
  }

  public static function getStatusLabels($status)
  {
    $labels = [
        Stamp::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        Stamp::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function getAllNames()
  {
    $model = Stamp::find()->where(['status'=>Stamp::STATUS_ACTIVE])->all();
    return ArrayHelper::map($model, 'id','name');
  }

  public static function getName($id)
  {
    $model = Stamp::findOne($id);
    return $model->name;
  }

  public static function listByCliche($id_cliche)
  {
    $stamps = ArrayHelper::getColumn(ClicheStamp::find()->where(['id_cliche'=>$id_cliche])->all(), 'id_stamp');
    $chk_stamps = [];
    foreach ($stamps as $stamp) {
      if ($stamp == 20) {
        $chk_stamps[] = $stamp;
      }
      if (StampPriceHelper::checkPrice($stamp)) {
        $chk_stamps[] = $stamp;
      }
    }
    return ArrayHelper::map(Stamp::find()->where(['id' => $chk_stamps])->all(), 'id', 'name');
  }

  public static function listBySize($id_size)
  {
    $stamps_list=[];
    $css= ArrayHelper::getColumn(ClicheSizeStamp::find()->where(['id_cliche_size' => $id_size])->all(), 'id_cliche_stamp');
    $id_stamp = ArrayHelper::getColumn(ClicheStamp::find()->where(['id'=>$css])->all(), 'id_stamp');
    $stamps = Stamp::find()->where(['id' => $id_stamp])->all();
    foreach ($stamps as $key => $stamp) {
        if ($stamp->id == 20) {
          $stamps_list[$stamp->id] = $stamp->name;
        }
        if (StampPriceHelper::checkPrice($stamp->id)) {
          $stamps_list[$stamp->id] = $stamp->name;
        }
    }
    return $stamps_list;

  }

  public static function stampsBySizeForSelect($id_size)
  {
    $stamps_list='';
    $css= ArrayHelper::getColumn(ClicheSizeStamp::find()->where(['id_cliche_size' => $id_size])->all(), 'id_cliche_stamp');
    $id_stamp = ArrayHelper::getColumn(ClicheStamp::find()->where(['id'=>$css])->all(), 'id_stamp');
    $stamps = Stamp::find()->where(['id' => $id_stamp])->all();
    foreach ($stamps as $key => $stamp) {
        if ($stamp->id == 20) {
          $stamps_list .= '<option value="20">Без оснастки</option>';
        }
        if (StampPriceHelper::checkPrice($stamp->id)) {
          $stamps_list .= '<option value="'.$stamp->id.'">'.$stamp->name.'</option>';
        }
    }
    return $stamps_list;

  }

  // public static function getStampsForSelect($id_cliche)
  // {
  //   $stamps_list='';
  //   $stamps_arr = ArrayHelper::getColumn(ClicheStamp::find()->where(['id_cliche'=>$id_cliche])->all(), 'id_stamp');
  //   $stamps = Stamp::find()->where(['id' => $stamps_arr])->all();
  //   foreach ($stamps as $stamp) {
  //       $stamps_list .= '<option value="'.$stamp->id.'">'.$stamp->name.'</option>';
  //   }
  //   return $stamps_list;
  // }

  public static function getStampsForSelect($css)
  {
    $stamps_list='';
    $stamps_arr = ArrayHelper::getColumn(ClicheStamp::find()->where(['id'=>$css])->all(), 'id_stamp');
    $stamps = Stamp::find()->where(['id' => $stamps_arr])->all();
    foreach ($stamps as $key => $stamp) {
      if ($key == 0) {
        $stamps_list .= '<option value="20">Без оснастки</option>';
      }
      if (StampPriceHelper::checkPrice($stamp->id)) {
        $stamps_list .= '<option value="'.$stamp->id.'">'.$stamp->name.'</option>';
      }

    }
    return $stamps_list;
  }

}
