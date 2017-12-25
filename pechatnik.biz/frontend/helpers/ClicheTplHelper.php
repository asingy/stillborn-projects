<?php
namespace frontend\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Cliche;
use frontend\models\ClicheTpl;
use backend\models\ClicheSize;
use backend\models\ProducerClicheTpl;
use backend\services\OrderService;
use yii\helpers\Url;

/**
 * Helper
 */
class ClicheTplHelper
{

  public function getList($id_cliche)
  {
    $pcs = ArrayHelper::getColumn(ProducerClicheTpl::findAll(['status' => ProducerClicheTpl::STATUS_ACTIVE]), 'id_cliche_tpl');
    $list = ClicheTpl::find()->where(['id_cliche' => $id_cliche])->andWhere(['id'=>$pcs])->orderBy('sort')->active()->all();
    return $list;
  }

  public function getFields($id_cliche_tpl)
  {
    $clicheTpl = ClicheTpl::find()->where(['id'=>$id_cliche_tpl])->active()->one();
    $clicheSizes = ArrayHelper::map(ClicheSize::findAll(['id_cliche' => $clicheTpl->id_cliche]), 'id', 'size');
    $clicheTplFields = json_decode($clicheTpl->fields);
    $size = '';
    if (Yii::$app->session['data_step3'] && Yii::$app->session['data_step3']['id_cliche_tpl'] === $id_cliche_tpl) {
      $data = Yii::$app->session['data_step3'];
      foreach ($clicheTplFields as $key => $value) {
          $value->val = $data[$value->field];
      }
      $size = $data['size'];
    } else {
      foreach ($clicheTplFields as $key => $value) {
        if ($value->field === 'city') {
          $value->val = 'Воронеж';
        }
      }
    }
    if ($id_cliche_tpl == Yii::$app->session['data_step3']['id_cliche_tpl']) {
      $svg = Yii::$app->session['svg'];
    }else{
      $svg = file_get_contents(Yii::getAlias('@backend').'/web/images/cliche_tpl/'.$clicheTpl->image);
    }
    return ['sizes'=>$clicheSizes, 'size' => $size ,'image'=>$svg, 'fields' => $clicheTplFields, 'id' => $clicheTpl->id];
  }

  public static function fieldsSerialize($id_cliche_tpl)
  {
    $fields = Yii::$app->session['data_step3'];
    // $fields['city'] = 1;
    return OrderService::serializeFields($fields, $id_cliche_tpl);
  }
}
