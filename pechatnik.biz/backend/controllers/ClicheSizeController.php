<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\ClicheSize;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use backend\helpers\ClicheSizeHelper;
use backend\models\ClicheSizeStamp;
use yii\helpers\Url;

/**
 * ClicheSizeController implements the CRUD actions for ClicheSize model.
 */
class ClicheSizeController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'delete' => ['POST'],
                 ],
             ],
             'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback'  => function ($rule, $action) {
                    Yii::$app->user->loginRequired();
                },
            ],
         ];
     }

     public function actionIndex()
     {
       $this->redirect('/site/index');
     }

     public function actionCreate($id_cliche)
     {
       $model = new ClicheSize();

       if ($model->load(Yii::$app->request->post())) {
         $model->id_cliche = $id_cliche;
         if (UploadedFile::getInstanceByName('image')){
            $image = $model->saveImage();
            $model->image = $image;
         }
         if ($model->save()) {
           Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
           return $this->redirect(Url::previous('url-cliche'));
         }
       }
       return $this->renderAjax('sizes_modal', [
           'model' => $model,
       ]);
     }

     public function actionUpdate($id)
     {
       $model = $this->findModel($id);
       $previous_image = $model->image;

       if ($model->load(Yii::$app->request->post())) {
         if (UploadedFile::getInstanceByName('image')){
           $image = $model->saveImage($previous_image);
           $model->image = $image;
         }
         if ($model->save()) {
           Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
           return $this->redirect(Url::previous('url-cliche'));
         }
       }
       return $this->renderAjax('sizes_modal', [
           'model' => $model,
       ]);
     }

     public function actionDelete($id)
     {
       $model = $this->findModel($id);
       if($model->delete()){
         $cliche_sizes = ClicheSizeStamp::find()->where(['id_cliche_size' => $id])->all();
         if($cliche_sizes){
           foreach ($cliche_sizes as $sz) {
             $sz->delete();
           }
         }
         Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
       }
       return $this->redirect(Url::previous('url-cliche'));
     }

    public function actionGet_sizes($id_cliche)
    {
      return ClicheSizeHelper::getSizes($id_cliche);
    }

    protected function findModel($id)
    {
        if (($model = ClicheSize::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
