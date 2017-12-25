<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Producer;
use backend\models\Contact;
use backend\models\AgentProducer;
use backend\models\Stamp;
use backend\search\DeliverySearch;
use backend\search\ProducerSearch;
use backend\search\ClicheTplSearch;
use backend\search\StampSearch;
use backend\search\ProducerStampSearch;
use backend\search\ProducerClichePriceSearch;
use backend\search\ProducerClicheTplSearch;
use backend\helpers\ProducerHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * ProducersController implements the CRUD actions for Producers model.
 */
class ProducerController extends Controller
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

    /**
     * Lists all Producers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProducerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGet_producer($id_cliche_tpl, $id_stamp)
    {
      return ProducerHelper::getForSelect($id_cliche_tpl, $id_stamp);
    }

    /**
     * Displays a single Producers model.
     * @param integer $id
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new Producer();
         $contact = new Contact();
         if (Yii::$app->request->isAjax && $contact->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($contact);
         }
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($contact->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
             $contact->type = Contact::TYPE_PRODUCER;
             if ($contact->save(false)) {
               if ($model->is_default == 1) {
                 $this->clearIsDefault();
               }
               $model->id_contact = $contact->id;
               if ($model->save(false)) {
                 Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
                 return $this->redirect(['index']);
               }
             }
         }
         $contact->id_city = \Yii::$app->user->identity->id_city;
         return $this->render('crud', [
             'contact' => $contact,
             'model' => $model,
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
         $contact = Contact::findOne($model->id_contact);
         $producerClichePrice = new ProducerClichePriceSearch();
         $producerStamp = new ProducerStampSearch();
         $delivery = new DeliverySearch();
         $producerClicheTpl = new ProducerClicheTplSearch();

         if (Yii::$app->request->isAjax && $contact->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($contact);
         }
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($contact->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
             if ($model->is_default == 1) {
               $this->clearIsDefault();
             }
             if ($contact->save(false) && $model->save(false)) {
                 Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
                 return $this->redirect(['index']);
             }
         }
           return $this->render('crud', [
               'model' => $model,
               'contact' => $contact,
               'dpClichePrice' => $producerClichePrice->searchByProducer($model->id),
               'dpClicheTpl' => $producerClicheTpl->searchByProducer($model->id),
               'dpStamp' => $producerStamp->searchByProducer($model->id),
               'dpDelivery' => $delivery->searchByProducer($model->id),
           ]);

     }

     protected function clearIsDefault()
     {
       $model = Producer::find()->where(['is_default' => Producer::DEFAULT])->one();
       if ($model) {
         $model->is_default = 0;
         $model->update();
       }

     }

    /**
     * Deletes an existing Producers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      // $model = $this->findModel($id);
      // if($model->delete()){
      //   Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
      // }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Producers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
