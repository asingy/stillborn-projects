<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 28.11.17
 * Time: 15:50
 */

namespace frontend\controllers;


use Yii;

class PaymentController extends BaseController
{
    public function actions()
    {
        return [
            'check' => [
                'class' => 'frontend\actions\CheckOrderAction',
                'beforeResponse' => function ($request) {
                    /**
                     * @var \yii\web\Request $request
                     */
                    $invoice_id = (int) $request->post('orderNumber');
                    if (!$invoice_id) {
                        Yii::warning("Кто-то хотел купить несуществующую печать! InvoiceId: {$invoice_id}",
                            Yii::$app->yakassa->logCategory);
                        return false;
                    }
                    
                    return true;
                }
            ],
            'aviso' => [
                'class' => 'frontend\actions\PaymentAvisoAction',
                'beforeResponse' => function ($request) {
                    /**
                     * @var \yii\web\Request $request
                     */
                }
            ],
        ];
    }

    public function actionFail()
    {
        return $this->renderResponse('Ошибка платежа!', 'fail');
    }

    public function actionSuccess()
    {
        return $this->renderResponse('Платеж прошел успешно!', 'success');
    }

    private function renderResponse($title, $view)
    {
        Yii::$app->session->destroy();

        $this->setTitle($title);

        $number = Yii::$app->request->get('orderNumber');

        return $this->render($view, ['number' => $number]);
    }
}