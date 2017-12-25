<?php

namespace backend\helpers;

use Yii;
use backend\models\Message;
use yii\helpers\ArrayHelper;
class MessageHelper
{

  public static function countNew()
  {
    return Message::find()->where(['status'=>Message::STATUS_NEW])->count();
  }

}
