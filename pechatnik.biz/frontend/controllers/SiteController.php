<?php
namespace frontend\controllers;

use backend\models\ClicheSize;
use backend\models\Order;
use common\models\TemplateSettings;
use frontend\models\ClicheTpl;
use frontend\models\Pages;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\services\CreateService;
use frontend\models\Create5Form;
use backend\models\Config;
use backend\models\Message;
use backend\helpers\ConfigHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\helpers\DeliveryHelper;
use frontend\helpers\OrderHelper;
 use frontend\helpers\ClicheHelper;
/**
 * Site controller
 */
class SiteController extends BaseController
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->session['step'] = 1;
        Yii::$app->session['price'] = 0;
        if (isset(Yii::$app->session['order'])) {
          $order = Yii::$app->session['order'];
          Yii::$app->session->destroy();
        }else{
          $order = null;
        }
        
        $cliche_list = ClicheHelper::typesList();
        return $this->render('index', [
          'order' => $order,
          'cliche_list' => $cliche_list,
        ]);
    }

    public function actionPage($slug)
    {
        $page = Pages::findBySlug($slug);

        if (is_null($page)) throw new NotFoundHttpException();

        $this->setTitle($page->getTitle());
        $this->setMetaDescription($page->meta_description);
        $this->setMetaKeywords($page->meta_keywords);

        return $this->render('page', ['model' => $page]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate($step)
    {
      if (!isset(Yii::$app->session['step'])) {
        return $this->redirect(['index']);
      }
      if (Yii::$app->request->isPost) {
        $cs = new CreateService($step, Yii::$app->request->post());
        $data = $cs->next();
      }else{
        $data = CreateService::back($step);
      }
      return $this->renderAjax('blocks/create/_create'.$step,['data'=> $data]);
    }

    public function actionGet_delivery($id_delivery)
    {
      if ($id_delivery == 1) {
        return Html::textInput('delivery_address', '', ['class' => 'constructor-input', 'placeholder'=> 'Адрес']);
      }
      return Html::dropDownList('delivery_address', '', DeliveryHelper::getList(), ['class' => 'form-control constructor-select', 'required'=>'required']) . '<i class="zmdi zmdi-chevron-down"></i>';
    }

    public function actionNew_order()
    {
      if (Yii::$app->request->isPost) {
        $number = CreateService::saveOrder();

        if (is_array($number) && isset($number['payment'])) {
            return $this->redirect(['yakassa',
                'sum' => $number['payment']['sum'],
                'customerNumber' => $number['payment']['customerNumber'],
                'paymentType' => $number['payment']['paymentType'],
                'cps_phone' => $number['payment']['cps_phone'],
                'cps_email' => $number['payment']['cps_email'],
                'orderNumber' => $number['payment']['orderNumber']
            ]);
        }

        Yii::$app->session['order'] = 'Заказ № '. $number;
        return $this->redirect(['index']);
      }
    }

    public function actionYakassa()
    {
        $request = Yii::$app->request;

        return $this->render('payment', [
            'sum' => $request->get('sum'),
            'customerNumber' => $request->get('customerNumber'),
            'paymentType' => $request->get('paymentType'),
            'cps_phone' => $request->get('cps_phone'),
            'cps_email' => $request->get('cps_email'),
            'orderNumber' => $request->get('orderNumber')
        ]);
    }

    public function actionOrder($query)
    {
        return OrderHelper::getInfo($query);
    }

    public function actionMessage()
    {
      $model = new Message();
      if (Yii::$app->request->isPost) {
        $model->id_user_from = 0;
        $model->id_user_to = 1;
        $model->is_feedback = 1;
        $model->text = Yii::$app->request->post('message');
        $model->info = Yii::$app->request->post('email') . ', '. Yii::$app->request->post('phone') . ', '. Yii::$app->request->post('name');
        $model->save();
      }
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $scan = UploadedFile::getInstanceByName('scansFile');
        if ($scan) {
            $file = pathinfo($scan->name);
            $filename = uniqid('f-').'.'.$file['extension'];
            $path = Yii::getAlias('@backend-webroot').'/files/scans/';
            if($scan->saveAs($path.$filename)) {
                return [$filename];
            }
        }

        return ['error'=>Yii::t('app', 'При загрузке файла произошла ошибка.')];
    }

    public function actionGetTemplate($id, $size)
    {
        if (Yii::$app->request->isAjax) {
            $model = ClicheSize::find()->where(['id'=>$size])->andWhere(['not', ['image'=>null]])->one();

            if ($model) {
                return $model->getTemplate();
            }

            $templateModel = ClicheTpl::find()->active()->where(['id'=>$id])->one();
            
            if ($templateModel) {
                return $templateModel->getTemplate();
            }
        }

        throw new NotFoundHttpException();
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id=='error')
                 $this->layout ='error';
            return true;
        } else {
            return false;
        }
    }


}
