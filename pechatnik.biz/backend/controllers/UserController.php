<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\search\UserSearch;
use backend\services\RbacService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
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
	 * Lists all User models.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch;
		$dataProvider = $searchModel->search($_GET);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}


	/**
	 * Creates a new User model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new User;

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
    }

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			RbacService::Assign($model->role, $model->username);
			Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Пользователь создан']);
			return $this->redirect(['index']);
		}

		return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);
	}

	/**
	 * Updates an existing User model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->role = key(Yii::$app->authManager->getRolesByUser($id));
		$model->setScenario('profile');

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
    }

        // if (isset($_POST['User']['password'])) {
        //     $model->setPassword($_POST['User']['password']);
        // }

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Пользователь изменен']);
			return $this->redirect(['index']);
		}
		return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);
	}

	/**
	 * Deletes an existing User model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		if ($model->delete()) {
			Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Пользователь удалён']);
		}
		return $this->redirect(['index']);
	}

	/**
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 * @return User the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = User::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
