<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 16.09.17
 * Time: 3:02
 */
namespace common\events;


use backend\models\Notice;
use backend\models\Order;

class OrderStatusEvent extends \yii\base\Event
{
    // @TODO Перенести все события заказов в этот класс

    /** @var  Order $model */
    public $model;

    /**
     * @return string|bool
     */
    public function getType()
    {
        if (isset($this->data['type']))
        {
            return $this->data['type'];
        }

        return false;
    }
}