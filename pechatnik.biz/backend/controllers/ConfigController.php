<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\Config;
use backend\search\ConfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * ConfigsController implements the CRUD actions for Configs model.
 */
class ConfigController extends Controller
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
      									'roles' => ['admin'],
      							],
      					],
      					'denyCallback'  => function ($rule, $action) {
      							Yii::$app->user->loginRequired();
      					},
      			],
        ];
    }

    /**
     * Lists all Configs models.
     * @return mixed
     */
    public function actionIndex($type)
    {
        $searchModel = new ConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    public function actionCreate($type)
    {
        $model = new Config();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->type = $type;
            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
              return $this->redirect(['index', 'type'=>$type]);
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
            return $this->redirect(['index', 'type'=>$model->type]);
          }
        }
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);

    }


    /**
     * Deletes an existing Configs model.
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
     * Finds the Configs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Configs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
