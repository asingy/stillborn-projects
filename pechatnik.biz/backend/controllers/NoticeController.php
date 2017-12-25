<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Notice;
use backend\search\NoticeSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * NoticesController implements the CRUD actions for Notices model.
 */
class NoticeController extends Controller
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
     * Lists all Notices models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        if($id === null){
          $id = 1;
        }
        $model = $this->findModel($id);
        $group = $this->findGroup($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Запись изменена']);
              return $this->redirect(['index']);
            }
        }
        return $this->render('index', [
            'model' => $model,
            'group' => $group
        ]);
    }

    public function actionCreate()
    {
        $model = new Notice();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user_from = Yii::$app->user->identity->id;
            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Сообщение отправлено']);
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
            return $this->redirect(['index', 'id'=>$model->group]);
          }
        }
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Notices model.
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
     * Finds the Notices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Notices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice[] the loaded models
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findGroup($id)
    {
        if (($model = Notice::find()->where(['group'=>$id])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
