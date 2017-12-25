<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\ClicheStamp;
use backend\models\ClicheSizeStamp;
use backend\models\ClicheSize;
use backend\search\StampSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * StampTypesCasesController implements the CRUD actions for StampTypesCases model.
 */
class ClicheStampController extends Controller
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
     * Lists all StampTypesCases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ClicheStamp::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate($id)
    {
        $searchModel = new StampSearch();
        $dataProvider = $searchModel->searchByCliche($id);
        if (Yii::$app->request->isPost && $selected = Yii::$app->request->post('selection')) {
          foreach ($selected as $select) {
            $ap = new ClicheStamp();
            $ap->id_stamp = $select;
            $ap->id_cliche = $id;
            $ap->save();
          }
          Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
          return $this->redirect(Url::previous('url-cliche'));
        }
        return $this->renderAjax('select_modal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing StampTypesCases model.
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

    public function actionShow_sizes($id_cliche, $id_cliche_stamp)
    {
      if ($model = ClicheSizeStamp::find()->where(['id_cliche' => $id_cliche, 'id_cliche_stamp' =>$id_cliche_stamp])->all()) {
        $selected = ArrayHelper::getColumn($model, 'id_cliche_size');
      }else{
        $model = new ClicheSizeStamp();
        $selected = '';
      }

      $sizes = ArrayHelper::map(ClicheSize::find()->where(['id_cliche' => $id_cliche])->all(), 'id', 'size');

      return $this->renderAjax('size_modal', [
          // 'model' => $model,
          'sizes' => $sizes,
          'selected' => $selected,
          'id_cliche' => $id_cliche,
          'id_cliche_stamp' => $id_cliche_stamp,
      ]);
    }

    public function actionChange_size()
    {
      if (Yii::$app->request->isPost) {
        $id_cliche_stamp = Yii::$app->request->post('id_cliche_stamp');
        $id_cliche = Yii::$app->request->post('id_cliche');
        $id_cliche_size = Yii::$app->request->post('id_cliche_size');
        if($m = ClicheSizeStamp::find()->where(['id_cliche' => $id_cliche, 'id_cliche_stamp' =>$id_cliche_stamp, 'id_cliche_size' => $id_cliche_size])->one()){
            $m->delete();
        }else{
          $model1 = new ClicheSizeStamp();
          $model1->id_cliche = $id_cliche;
          $model1->id_cliche_stamp = $id_cliche_stamp;
          $model1->id_cliche_size = $id_cliche_size;
          $model1->save(false);
        }
        Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
      }
    }

    /**
     * Deletes an existing StampTypesCases model.
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

        return $this->redirect(Url::previous('url-cliche'));
    }

    /**
     * Finds the StampTypesCases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StampTypesCases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClicheStamp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
