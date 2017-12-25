<?php
namespace frontend\helpers;

use Yii;
use backend\models\Cliche;
use backend\models\ClicheSize;
use backend\models\ClichePrice;
/**
 * Helper
 */
class ClicheHelper
{

  public function typesList()
  {
    return Cliche::find()->where(['status'=>Cliche::STATUS_ACTIVE])->orderBy('sort')->all();
  }

  public function getPrice()
  {
    $id_cliche = Yii::$app->session['data_step1'];
    $id_cliche_size = Yii::$app->session['data_step3']['size'];
    $cp = ClichePrice::find()->where(['id_cliche' => $id_cliche, 'id_cliche_size' => $id_cliche_size])->one();
    if ($cp) {
      return $cp->price;
    }
    return 0;
  }

  public static function getSize($id_size)
  {
    return ClicheSize::findOne($id_size)->size;
  }
}
