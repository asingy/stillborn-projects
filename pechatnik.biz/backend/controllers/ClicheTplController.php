<?php

namespace backend\controllers;

use common\models\TemplateSettings;
use Yii;
use yii\filters\AccessControl;
use backend\models\ClicheTpl;
use backend\helpers\ClicheTplHelper;
use backend\helpers\ConfigHelper;
use backend\search\ClicheTplSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * ClicheTplController implements the CRUD actions for ClicheTpl model.
 */
class ClicheTplController extends Controller
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
     * Lists all StampTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClicheTplSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {
        $searchModel = new ClicheTplSearch();
        $dataProvider = $searchModel->search_add(Yii::$app->request->queryParams);

        return $this->renderAjax('select_modal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGet_data($id_cliche_tpl)
    {
      $model = $this->findModel($id_cliche_tpl);
      $data['image'] = file_get_contents(Yii::getAlias('@backend').'/web/images/cliche_tpl/'.$model->image);
      if ($model->fields !== '') {
        $data['fields'] = $this->renderAjax('/order/_fields',['fields'=>json_decode($model->fields)]);
      } else {
        $data['fields'] = '';
      }
      return json_encode($data);
    }

    /**
     * Displays a single StampTemplates model.
     * @param integer $id
     * @return mixed
     */
     protected function saveImage($previous_image = '')
     {
         $image = UploadedFile::getInstanceByName('image');
         if ($image) {
             $file = pathinfo($image->name);
             $filename = uniqid().'.'.$file['extension'];
             $path = Yii::getAlias('@webroot').'/images/cliche_tpl/';
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

    /**
     * Creates a new StampTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_cliche)
    {
        $model = new ClicheTpl();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->image = $this->saveImage();
            $model->id_cliche = $id_cliche;
            if ($model->save()) {
              Yii::$app->getSession()->setFlash('', ['type'=>'success','message' => 'Информация сохранена']);
              return $this->redirect(Url::previous('url-cliche'));
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
            return $this->redirect(Url::previous('url-cliche'));
          }
        }
        return $this->renderAjax('form_modal', [
            'model' => $model,
        ]);

    }

    public function actionFields($id)
    {
        $model = $this->findModel($id);
        $list = ConfigHelper::getClicheTplFieldsForSelect();
        // $fields = ClicheTplHelper::getFields($id);
        if (Yii::$app->request->isPost && $field = Yii::$app->request->post('field')) {
          $fd = json_decode($model->fields, true);
          $lis = ConfigHelper::getClicheTplFieldsList();
          $fd[] = ['field'=>$field, 'name'=>$lis[$field]];
          $model->fields = json_encode($fd);

          if ($model->update(false)) {
            $t= '';
            foreach (json_decode($model->fields) as $key => $value){
              $t .= '<p>'.$value->name. Html::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'delete btn btn-xs btn-flat btn-danger pull-right', 'data-field'=>$value->field]) . '</p>';
            }
            echo $t;
          }
        }else{
          return $this->renderAjax('fields_modal', [
              'fields' => $model->fields === '' ? '' : json_decode($model->fields),
              'list' => $list,
              'model' => $model,
              'editorModel' => ''
          ]);
        }
    }

    public function actionGetTemplate($id)
    {
        $model = ClicheTpl::findOne($id);

        if (Yii::$app->request->isAjax && $model) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $template = $model->getTemplate();

            if ($template) {
                return ['status' => 'success', 'template' => $template];
            }
        }

        return ['status'=>'error'];
    }

    public function actionEditTemplate($id, $field)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $template = TemplateSettings::findOne(['template_id'=>$id, 'field'=>$field]);
        $model = $template ? $template : new TemplateSettings(['field' => $field, 'template_id' => $id]);

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return ['status'=>'ok'];
            }

            return ['status'=>'error', 'errors'=>$model->errors];
        }

        return ['status'=>'success', 'template'=>$this->renderAjax('edit-template', ['model'=>$model])];
    }

    public function actionDelete_field($id)
    {
      if (Yii::$app->request->isPost && $field = Yii::$app->request->post('field')) {
        $model = $this->findModel($id);
        $fd = json_decode($model->fields, true);
        foreach ($fd as $key => $value) {
          if ($value['field'] === $field) {
            unset($fd[$key]);
          }
        }
        $model->fields = json_encode(array_values($fd));
        if ($model->update(false)) {
          $t= '';
          foreach (json_decode($model->fields) as $key => $value){
            $t .= '<p>'.$value->name. Html::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'delete btn btn-xs btn-flat btn-danger pull-right', 'data-field'=>$value->field]) . '</p>';
          }
          echo $t;
        }
      }
    }

    /**
     * Deletes an existing StampTemplates model.
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
     * Finds the StampTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StampTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClicheTpl::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
