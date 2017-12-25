<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\ProducerClichePrice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use backend\services\ClicheSizeService;
use yii\helpers\Url;
/**
 * StampCasesController implements the CRUD actions for ProduserStampPrices model.
 */
class ProducerClichePriceController extends Controller
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

     public function actionCreate($id_producer)
     {
         $model = new ProducerClichePrice();

         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($model->load(Yii::$app->request->post())) {
           $model->id_producer = $id_producer;
             if ($model->save()) {
               Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
               return $this->redirect(Url::previous('url-producer'));
             }
         }
         return $this->renderAjax('form_modal', [
             'model' => $model,
             'stamp_sizes_list' => [],
         ]);

     }

     /**
      * Updates an existing StampTypes model.
      * If update is successful, the browser will be redirected to the 'view' page.
      * @param integer $id
      * @return mixed
      */
     public function actionUpdate($id)
     {
         $model = $this->findModel($id);
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($model->load(Yii::$app->request->post())) {

           if ($model->save()) {
             Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
             return $this->redirect(Url::previous('url-producer'));
           }
         }
         return $this->renderAjax('form_modal', [
             'model' => $model,
             'stamp_sizes_list' => ClicheSizeService::getSizesArray($model->id_cliche),
         ]);

     }

     public function actionDelete($id)
     {
       $model = $this->findModel($id);
       if($model->delete()){
         Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
       }

         return $this->redirect(Url::previous('url-producer'));
     }

    //  public function actionBatch()
    //  {
    //     $sz = \backend\models\StampSizes::find()->where(['id_stamp_type' => 5])->all();
    //    foreach ($sz as $value) {
    //      $model = new ProducerStampPrices();
    //      $model->price = 100;
    //      $model->id_producer = 1;
    //      $model->id_stamp_type = 5;
    //      $model->id_stamp_size = $value->id;fix
    //      $model->status = 1;
    //      $model->save(false);
    //    }
    //    return 'Done';
    //  }

    protected function findModel($id)
    {
        if (($model = ProducerClichePrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
