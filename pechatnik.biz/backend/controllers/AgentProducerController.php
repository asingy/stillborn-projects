<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\AgentProducer;
use backend\search\ProducerSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * AgentProducerController implements the CRUD actions for AgentProducers model.
 */
class AgentProducerController extends Controller
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
     * Lists all AgentProducers models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $dataProvider = new ActiveDataProvider([
        //     'query' => AgentProducer::find(),
        // ]);
        //
        // return $this->render('index', [
        //     'dataProvider' => $dataProvider,
        // ]);

      $this->redirect('/site/index');
    }


    /**
     * Creates a new AgentProducers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate($id)
    {
        $searchModel = new ProducerSearch();
        $dataProvider = $searchModel->searchByAgent($id);
        if (Yii::$app->request->isPost && $selected = Yii::$app->request->post('selection')) {
          foreach ($selected as $select) {
            $ap = new AgentProducer();
            $ap->id_agent = $id;
            $ap->id_producer = $select;
            $ap->save(false);
          }
          Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
          return $this->redirect(Url::previous('url-agent'));
        }
        return $this->renderAjax('select_modal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing AgentProducers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing AgentProducers model.
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
      return $this->redirect(Url::previous('url-agent'));
    }

    /**
     * Finds the AgentProducers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgentProducers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentProducer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
