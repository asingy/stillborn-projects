<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use backend\models\Cliche;
use backend\models\ClicheSize;
use backend\search\ClicheSearch;
use backend\search\ClicheTplSearch;
use backend\search\ClicheStampSearch;
use backend\search\ClicheSizeSearch;
use backend\models\ClicheSizeStamp;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * ClicheController implements the CRUD actions for Cliche model.
 */
class ClicheController extends Controller
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
     * Lists all Cliche models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClicheSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cliche model.
     * @param integer $id
     * @return mixed
     */
     protected function saveImage($previous_image = null)
     {
         $image = UploadedFile::getInstanceByName('image');
         if ($image) {
             $file = pathinfo($image->name);
             $filename = uniqid().'.'.$file['extension'];
             $path = Yii::getAlias('@webroot').'/images/cliche/';
             if($image->saveAs($path.$filename)){
                 if ($previous_image !== null) {
                     unlink($path . $previous_image);
                 }
                 return $filename;
             }
         }else{
             return '';
         }
     }

     public function actionGet_image($id_cliche)
     {
       $model = $this->findModel($id_cliche);
       return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/cliche/'.$model->image, true), ['style'=>'max-width: 100%;max-height: 100%;']);
     }

    /**
     * Creates a new Cliche model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cliche();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->image = $this->saveImage();
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
     * Updates an existing Cliche model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $clicheTpl = new ClicheTplSearch();
        $clicheStamp = new ClicheStampSearch();
        $clicheSize = new ClicheSizeSearch();
        $previous_image = $model->image;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
          if (UploadedFile::getInstanceByName('image')){
            $image = $this->saveImage($previous_image);
            $model->image = $image;
          }
          if ($model->save()) {
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(['index']);
          }
        }
          return $this->render('crud', [
              'model' => $model,
              'dpStamps' => $clicheTpl->searchByCliche($id),
              'dpStampCases' => $clicheStamp->searchByCliche($model->id),
              'dpStampSizes' => $clicheSize->searchByCliche($model->id),
          ]);

    }


    /**
     * Deletes an existing Cliche model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      $model->status = Cliche::STATUS_INACTIVE;
      if($model->update()){
        Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
      }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cliche model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliche the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliche::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
