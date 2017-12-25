<?php

namespace backend\helpers;

use Yii;
use backend\models\ClicheTpl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ClicheTplHelper
{
  private static $stats_name = [
    ClicheTpl::STATUS_INACTIVE => 'Не активен',
    ClicheTpl::STATUS_ACTIVE => 'Активен',
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
        ClicheTpl::STATUS_ACTIVE =>'<span class="label label-success">Активен</span>',
        ClicheTpl::STATUS_INACTIVE =>'<span class="label label-danger">Не активен</span>',
    ];
    return $labels[$status];
  }

  public static function listByCliche($id_cliche)
  {
    return ArrayHelper::map(ClicheTpl::find()->where(['id_cliche' => $id_cliche])->all(), 'id', 'name');
  }

  public static function getClicheTplForSelect($id_cliche)
  {
    $tpl_list='';
    $clicheTpl = ClicheTpl::find()->where(['id_cliche' => $id_cliche])->all();
    foreach ($clicheTpl as $key => $tpl) {
        if($key == 0){
          $first_tpl = $tpl->id;
          $svg = $tpl->image;
        }
        $tpl_list .= '<option value="'.$tpl->id.'">'.$tpl->name.'</option>';
    }
    $svg_src = file_get_contents(Yii::getAlias('@backend').'/web/images/cliche_tpl/'. $svg);
    return ['select' => $tpl_list, 'svg' => $svg_src ];
  }

  public static function getFields($id)
  {
    $model = ClicheTpl::findOne($id);
    return $model->fields;
  }


}
