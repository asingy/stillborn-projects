<?php

namespace backend\controllers;

use common\events\OrderStatusEvent;
use Yii;
use backend\models\Order;
use backend\models\Cliche;
use backend\models\ClicheTpl;
use backend\search\OrderSearch;
use backend\services\OrderService;
use backend\services\ReportService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\helpers\OrderHelper;
use backend\helpers\ClicheSizeHelper;
use backend\helpers\ClicheTplHelper;
use backend\helpers\ClicheHelper;
use backend\helpers\StampHelper;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrderController extends Controller
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGet_data($id_cliche)
    {
      $clicheTpl = ClicheTplHelper::getClicheTplForSelect($id_cliche);
      $clicheParams = ClicheSizeHelper::getSizesForOrder($id_cliche);
      $fields = $this->getFields($id_cliche);
      return json_encode(['cliche_tpl'=>$clicheTpl['select'],
                          'cliche_sizes'=>$clicheParams['sizes'],
                          'stamps' => $clicheParams['stamps'],
                          'fields' => $fields,
                          'svg' => $clicheTpl['svg'],
                        ]);
    }

    // protected function getFields($id_cliche)
    // {
    //   $cliche_type = Cliche::findOne($id_cliche)->type;
    //   return $this->renderAjax('fields/_'.Order::$field_views[$cliche_type],['fields'=>'']);
    // }

    protected function getFields($id_cliche)
    {
      $cliche_tpl = ClicheTpl::findOne(['id_cliche'=>$id_cliche]);
      if ($cliche_tpl->fields !== '') {
        $fields = json_decode($cliche_tpl->fields);
        return $this->renderAjax('_fields',['fields'=>$fields]);
      }
      return '';
    }

    protected function saveScans($model, $previous_scan = '')
    {
        $scan = UploadedFile::getInstance($model, 'scansFile');
        if ($scan) {
            $file = pathinfo($scan->name);
            $filename = uniqid().'.'.$file['extension'];
            $path = Yii::getAlias('@webroot').'/files/scans/';
            if($scan->saveAs($path.$filename)){
              if ($previous_scan !== '') {
                  unlink($path . $previous_scan);
              }
                return $filename;
            }
        }else{
            return '';
        }
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if(Yii::$app->session->has('id_order_client')){
            $model->id_client = Yii::$app->session->get('id_order_client');
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->number = OrderHelper::getNumber($model);
            $model->cost = OrderHelper::getCost($model);
            $model->id_user = Yii::$app->user->id;
            $model->id_city = Yii::$app->user->identity->id_city;
            $model->scans = $this->saveScans($model);
            if ($fields = Yii::$app->request->post('Order_fields')) {
              $model->cliche_fields = OrderService::serializeFields($fields, $model->id_cliche_tpl);
            }

          if ($model->save()) {
            Yii::$app->session->remove('id_order_client');
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(['index']);
          }
        }
        $model->quantity = 1;
        return $this->render('crud', [
            'model' => $model,
            'id_cliche' => '',
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $previous_scans = $model->scans;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
          if ($fields = Yii::$app->request->post('Order_fields')) {
            $model->cliche_fields = OrderService::serializeFields($fields, $model->id_cliche_tpl);
          }
          if ($model->status == Order::STATUS_CLOSE) {
            $model->date_close = date('Y-m-d');
          }
          if (UploadedFile::getInstance($model, 'scansFile')){
            $model->scans = $this->saveScans($model, $previous_scans);
          }

          $mailTrigger = $model->getOldAttribute('status') != $model->status;

          if ($model->save()) {
              if ($mailTrigger) {
                  $model->trigger(Order::$statusMapping[$model->status], new OrderStatusEvent(['model' => $model]));
              }

            if ($model->status == Order::STATUS_CLOSE) {
              ReportService::writeOrder($model);
            }
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(['index']);
          }
        }
        return $this->render('crud', [
            'model' => $model,
            'id_cliche' => $model->cliche_tpl->id_cliche,
            'fields' => json_decode($model->cliche_fields),
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      if($model->delete()){
        Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
      }

      return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
