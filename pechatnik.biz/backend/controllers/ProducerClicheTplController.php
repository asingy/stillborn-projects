<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\ProducerClicheTpl;
use backend\models\ClicheTpl;
use backend\search\ClicheTplSearch;
use backend\services\ProducerService;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ProducerClicheTplController implements the CRUD actions for ProducerClicheTpl model.
 */
class ProducerClicheTplController extends Controller
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
     * Lists all ProducerStampTpl models.
     * @return mixed
     */
     public function actionIndex($producer)
     {
         $searchModel = new ClicheTplSearch();
         $dataProvider = $searchModel->search_by_producer(Yii::$app->request->queryParams, $producer);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);
     }

    /**
     * Displays a single ProducerStampTpl model.
     * @param integer $id
     * @return mixed
     */
    public function actionGet($id_producer, $id_cliche)
    {
        return ProducerService::getTpl($id_producer, $id_cliche);
    }

    public function actionCreate($id, $id_cliche)
    {
        $searchModel = new ClicheTplSearch();
        $dataProvider = $searchModel->searchByProducer($id, $id_cliche);
        if (Yii::$app->request->isPost && $selected = Yii::$app->request->post('selection')) {
          foreach ($selected as $select) {
            $ap = new ProducerClicheTpl();
            $ap->id_cliche_tpl = $select;
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
     * Updates an existing ProducerStampTpl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProducerStampTpl model.
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
     * Finds the ProducerStampTpl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProducerStampTpl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProducerClicheTpl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
