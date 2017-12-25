<?php

namespace backend\services;

use Yii;
use backend\models\User;

class RbacService
{
  public function getRoles()
  {
    # code...
  }

  public static function Assign($role, $username)
  {
      $user = User::find()->where(['username' => $username])->one();
      if (!$user) {
          throw new InvalidParamException("There is no user \"$username\".");
      }

      $auth = Yii::$app->authManager;
      $roleObject = $auth->getRole($role);
      if (!$roleObject) {
          throw new InvalidParamException("There is no role \"$role\".");
      }

      $auth->assign($roleObject, $user->id);
  }
}
