<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 19.09.17
 * Time: 1:59
 */

namespace console\controllers;

use backend\models\Order;
use common\events\OrderStatusEvent;
use yii\base\Exception;
use yii\db\Expression;

class MailerController extends \yii\console\Controller
{
    public function actionIndex()
    {
        $orders = Order::find()
            ->where(new Expression('NOW() >= date + INTERVAL 2 DAY'))
            ->andWhere(['status'=>Order::STATUS_NEW])
            ->all();

        /** @var Order $order */
        foreach($orders as $order) {
            try {
                $order->trigger(Order::EVENT_STATUS_EXPIRED, new OrderStatusEvent(['model' => $order]));
                $order->status = Order::STATUS_EXPIRED;
                $order->update(false);
            }
            catch (\Exception $exception) {
                \Yii::error(['Send mail error - OrderID '.$order->id, $exception->getTraceAsString()]);
            }
        }
    }
}