<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\ProducerStamp;
use backend\models\Stamp;
use backend\search\ClicheStampSearch;
use backend\search\StampSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * ProducerStampCasesController implements the CRUD actions for ProducerStampCases model.
 */
class ProducerStampController extends Controller
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
     * Lists all ProducerStampCases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProducerStamp::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProducerStampCases model.
     * @param integer $id
     * @return mixed
     */
    public function actionGet_image($stamp)
    {
        $sc = Stamp::findOne($stamp);
        return Html::img(Url::to(Yii::$app->request->baseUrl.'/images/stamp/'.$sc->image, true), ['style'=>'max-height:200px']);
    }

    /**
     * Creates a new ProducerStampCases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($id)
    {
        $searchModel = new StampSearch();
        $dataProvider = $searchModel->searchByProducer($id);
        if (Yii::$app->request->isPost && $selected = Yii::$app->request->post('selection')) {
          foreach ($selected as $select) {
            $ap = new ProducerStamp();
            $ap->id_stamp = $select;
            $ap->id_producer = $id;
            $ap->save();
          }
          Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
          return $this->redirect(Url::previous('url-producer'));
        }
        return $this->renderAjax('select_modal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing ProducerStampCases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(Url::previous('url-producer'));
        }
        return $this->renderAjax('form_modal', [
          'model' => $model,
      ]);

    }

    /**
     * Deletes an existing ProducerStampCases model.
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

        return $this->redirect(Url::previous('url-producer'));
    }

    /**
     * Finds the ProducerStampCases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProducerStampCases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProducerStamp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
