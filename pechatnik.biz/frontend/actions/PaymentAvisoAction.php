<?php
/**
 * Created by PhpStorm.
 * User: krosh
 * Date: 26.04.2016
 * Time: 11:09
 */

namespace frontend\actions;

use backend\models\Order;
use common\events\OrderStatusEvent;
use kroshilin\yakassa\models\MD5;
use kroshilin\yakassa\YaKassa;
use Yii;

class PaymentAvisoAction extends BaseAction
{
    public $actionName = 'paymentAviso';

    public function run()
    {
        if ($this->getComponent()->securityType == YaKassa::SECURITY_MD5) {
            $model = new MD5();
            $model->load(Yii::$app->request->post(), "");
            $model->validate();

            $number = Yii::$app->request->post('orderNumber');
            $order = Order::findOne(['number'=>str_replace('VRN', '', $number)]);

            if ($order) {
                $order->status = Order::STATUS_PAID;
                if ($order->save()) {
                    $order->trigger(Order::EVENT_STATUS_ORDER, new OrderStatusEvent(['model' => $order]));
                }
            }

            return $this->getComponent()->buildResponse($this->actionName, $model->invoiceId, 0);
        } elseif ($this->component->securityType == YaKassa::SECURITY_PKCS7) {
            // TODO: write code for PKCS7
        }
        Yii::warning(Yii::t($this->getComponent()->messagesCategory, 'Got unknown security type message'), $this->getComponent()->logCategory);
        return $this->getComponent()->buildResponse($this->actionName, null, 200, Yii::t($this->getComponent()->messagesCategory, 'Got unknown security type message'));
    }
}