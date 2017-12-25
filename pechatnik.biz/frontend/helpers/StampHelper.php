<?php
namespace frontend\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Stamp;
use backend\models\ClicheStamp;
use backend\models\StampPrice;
use backend\models\ProducerStamp;
/**
 * Helper
 */
class StampHelper
{

  public function listByCliche($id_cliche)
  {
    $ps = ArrayHelper::getColumn(ProducerStamp::findAll(['status' => ProducerStamp::STATUS_ACTIVE]), 'id_stamp');
    $stamps = ArrayHelper::getColumn(ClicheStamp::find()->where(['id_cliche' => $id_cliche])->andWhere(['id_stamp'=>$ps])->all(), 'id_stamp');
    return StampPrice::findAll(['id_stamp' => $stamps]);
  }
}
