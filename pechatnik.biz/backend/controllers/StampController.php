<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\AccessControl;
use backend\models\Stamp;
use backend\helpers\StampHelper;
use backend\search\StampSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * StampController implements the CRUD actions for Stamp model.
 */
class StampController extends Controller
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
     * Lists all StampCases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StampSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {
        $searchModel = new StampSearch();
        $dataProvider = $searchModel->search_add(Yii::$app->request->queryParams);

        return $this->renderAjax('select_modal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StampCases model.
     * @param integer $id
     * @return mixed
     */
     protected function saveImage($previous_image = '')
     {
         $image = UploadedFile::getInstanceByName('image');
         if ($image) {
             $file = pathinfo($image->name);
             $filename = uniqid().'.'.$file['extension'];
             $path = Yii::getAlias('@webroot').'/images/stamp/';
             if($image->saveAs($path.$filename)){
               if ($previous_image !== '') {
                   unlink($path . $previous_image);
               }
                 return $filename;
             }
         }else{
             return '';
         }
     }

     public function actionGet_image($id_stamp)
     {
       $model = $this->findModel($id_stamp);
       return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$model->image, true), ['style'=>'max-width: 100%;max-height: 100%;']);
     }

     public function actionGet_stamp($id_size)
     {
       return StampHelper::stampsBySizeForSelect($id_size);
     }

    /**
     * Creates a new StampTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stamp();
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
     * Updates an existing StampTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
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
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StampCases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // if($model->image){
        //   unlink(Yii::getAlias('@webroot').'/images/stamp/'.$model->image);
        // }
        $model->deleted = Stamp::DELETED;
        if($model->update()){
          Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация удалена']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the StampCases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StampCases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stamp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
