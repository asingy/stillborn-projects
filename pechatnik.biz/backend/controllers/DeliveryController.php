<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Delivery;
use backend\models\Contact;
use backend\models\AgentProducer;
use backend\search\DeliverySearch;
use backend\helpers\DeliveryHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/**
 * DeliverysController implements the CRUD actions for Deliverys model.
 */
class DeliveryController extends Controller
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
     * Lists all Deliverys models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deliverys model.
     * @param integer $id
     * @return mixed
     */
    public function actionGet_pickups($id_producer)
    {
        $list = DeliveryHelper::getListByProducer($id_producer);
        return Html::label('Пункты выдачи', 'for', ['class' => 'control-label']) . Html::dropDownList('Order[delivery_address]', 'select', $list, ['id'=>'delivery_points','class' => 'form-control']);
    }



    /**
     * Creates a new Deliverys model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id, $contact_type)
    {
        $model = new Delivery();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if($contact_type ==  Contact::TYPE_PRODUCER){
                $model->id_producer = $id;
            }else{
                $model->id_agent = $id;
            }

            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
              return $this->redirect(Url::previous('url-delivery'));
            }
        }
        $model->id_city = \Yii::$app->user->identity->id_city;
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Deliverys model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(Url::previous('url-delivery'));
        }
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Deliverys model.
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

        return $this->redirect(Url::previous('url-delivery'));
    }

    /**
     * Finds the Deliverys model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deliverys the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Delivery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
