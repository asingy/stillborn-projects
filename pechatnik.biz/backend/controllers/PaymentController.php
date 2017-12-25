<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Payment;
use backend\search\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * PaymentsController implements the CRUD actions for Payments model.
 */
class PaymentController extends Controller
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
     * Lists all Payments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payments model.
     * @param integer $id
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new Payment();
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($model->load(Yii::$app->request->post())) {
             if ($model->save()) {
               Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
               return $this->redirect(['index']);
             }
         }
         return $this->renderAjax('form_modal', [
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
         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
         }
         if ($model->load(Yii::$app->request->post())) {
           if ($model->save()) {
             Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
             return $this->redirect(['index']);
           }
         }
         return $this->renderAjax('form_modal', [
             'model' => $model,
         ]);
     }

    /**
     * Deletes an existing Payments model.
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
     * Finds the Payments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
