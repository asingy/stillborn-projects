<?php

namespace backend\controllers;

use Yii;
use backend\models\Agent;
use backend\models\Contact;
use backend\search\AgentSearch;
use backend\search\AgentProducerSearch;
use backend\search\DeliverySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AgentsController implements the CRUD actions for Agents model.
 */
class AgentController extends Controller
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
     * Lists all Agents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Agents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agent();
        $contact = new Contact();

        if (Yii::$app->request->isAjax && $contact->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($contact);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($contact->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            $contact->type = Contact::TYPE_AGENT;
            if ($contact->save(false)) {
              $model->id_contact = $contact->id;
              if ($model->save(false)) {
                Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
                return $this->redirect(['index']);
              }
            }
        }
        $contact->id_city = \Yii::$app->user->identity->id_city;
        return $this->render('crud', [
          'contact' => $contact,
          'model' => $model,
        ]);

    }

    /**
     * Updates an existing Agents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contact = Contact::findOne($model->id_contact);
        $agentProducer = new AgentProducerSearch();
        $delivery = new DeliverySearch();

        if (Yii::$app->request->isAjax && $contact->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($contact);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($contact->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            if ($contact->save(false) && $model->save(false)) {
                Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
                return $this->redirect(['index']);
            }
        }

        return $this->render('crud', [
            'model' => $model,
            'contact' => $contact,
            'dpAgentProducer' => $agentProducer->searchByAgent($model->id),
            'dpDelivery' => $delivery->searchByAgent($model->id),
        ]);

    }

    /**
     * Deletes an existing Agents model.
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
     * Finds the Agents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
