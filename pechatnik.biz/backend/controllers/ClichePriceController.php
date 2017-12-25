<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\ClichePrice;
use backend\search\ClichePriceSearch;
use backend\helpers\ProducerClichePriceHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use backend\helpers\ClicheSizeHelper;

/**
 * ClichePriceController implements the CRUD actions for ClichePrice model.
 */
class ClichePriceController extends Controller
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
     * Lists all PriceStamps models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClichePriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new StampTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClichePrice();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if (ClichePrice::find()->where(['id_cliche' => $model->id_cliche, 'id_cliche_size' => $model->id_cliche_size, 'id_city' => $model->id_city])->one()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'warning','message' => 'Такая запись уже существует']);
            }else if(ProducerClichePriceHelper::checkCliche($model) === false){
              Yii::$app->getSession()->setFlash('', ['type'=>'warning','message' => 'Печать не найдена у производителей или цена реализации меньше']);
            }else{
              if ($model->save()) {
                Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
              }
            }
            return $this->redirect(['index']);
        }

        $model->id_city = \Yii::$app->user->identity->id_city;
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
          if(ProducerClichePriceHelper::checkCliche($model) === false){
            Yii::$app->getSession()->setFlash('', ['type'=>'warning','message' => 'Печать не найдена у производителей или цена реализации меньше']);
          }else{
            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            }
          }
          return $this->redirect(['index']);
        }
        return $this->renderAjax('form_modal', [
            'model' => $model,
            'stamp_sizes_list' => ClicheSizeHelper::getArraySizes($model->id_cliche),
        ]);

    }

    /**
     * Deletes an existing PriceStamps model.
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
     * Finds the PriceStamps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PriceStamps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClichePrice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
