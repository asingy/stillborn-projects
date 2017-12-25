<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 16.09.17
 * Time: 1:30
 */

namespace common\components;


use backend\helpers\ClicheSizeHelper;
use backend\helpers\StampPriceHelper;
use backend\models\Client;
use backend\models\Config;
use backend\models\Delivery;
use backend\models\Notice;
use backend\models\Order;
use backend\models\User;
use common\events\OrderStatusEvent;
use frontend\helpers\DeliveryHelper;
use Yii;
use yii\base\Component;

class Mailer extends Component
{
    const TEMPLATE_USER = 1;
    const TEMPLATE_AGENT_AUTO = 2;
    const TEMPLATE_AGENT = 3;
    const TEMPLATE_MANUFACTURER = 4;

    public static function sendMessage(OrderStatusEvent $event)
    {
        $order = $event->model;
        $type = $event->getType();

        $scanPath = Yii::getAlias('@backend-webroot').'/files/scans/'.$order->scans;

        static::send($order, $order->client->email,self::TEMPLATE_USER, $type, [
            [$order->png, ['fileName' => md5($order->id.time()).'.png', 'contentType' => 'image/png']]
        ]);
        static::send($order, $order->agent_producer->agent->contact->email,self::TEMPLATE_AGENT_AUTO, $type, [
            [$order->png, ['fileName' => md5($order->id.time()).'.png', 'contentType' => 'image/png']],
            [$order->svg, ['fileName' => md5($order->id.time()).'.svg', 'contentType' => 'image/svg+xml']],
            [file_get_contents($scanPath), ['fileName' => $order->scans, 'contentType' => mime_content_type($scanPath)]]
        ]);
        static::send($order, $order->agent_producer->agent->contact->email,self::TEMPLATE_AGENT, $type, [
            [$order->png, ['fileName' => md5($order->id.time()).'.png', 'contentType' => 'image/png']],
            [$order->svg, ['fileName' => md5($order->id.time()).'.svg', 'contentType' => 'image/svg+xml']],
            [file_get_contents($scanPath), ['fileName' => $order->scans, 'contentType' => mime_content_type($scanPath)]]
        ]);
        static::send($order, $order->producer->contact->info, self::TEMPLATE_MANUFACTURER, $event->getType(), [
            [$order->svg, ['fileName' => md5($order->id.time()).'.svg', 'contentType' => 'image/svg+xml']],
            [$order->png, ['fileName' => md5($order->id.time()).'.png', 'contentType' => 'image/png']],
            [file_get_contents($scanPath), ['fileName' => $order->scans, 'contentType' => mime_content_type($scanPath)]]
        ]);
    }

    protected static function send(Order $order, $to, $template, $trigger, $attachments = [])
    {
        $from = [Config::findOne(['name'=>'contacts.email'])->param => 'Печатник'];

        $templateVars = [
            'order-id' => $order->id,
            'user-name' => $order->client->name,
            'order-number' => $order->number,
            'order-date' => $order->date,
            'user-email' => $order->client->email,
            'user-phone' => $order->client->phone,
            'cliche' => $order->cliche_tpl->name,
            'cliche-tpl' => $order->cliche_tpl->name,
            'stamp' => $order->stamp->name.' '.StampPriceHelper::getPrice($order->stamp->id),
            'cliche-size' => $order->clicheSize->size,
            'order-qty' => $order->quantity,
            'order-delivery' => DeliveryHelper::getDeliveryType(Delivery::TYPE_TO_HAND),
            'order-delivery-address' => $order->delivery_address,
            'order-payment' => $order->payment->name,
            'order-cost' => $order->cost
        ];

        if ($order->id_delivery == Delivery::TYPE_PICKUP) {
            $templateVars['order-delivery'] = DeliveryHelper::getDeliveryType($order->id_delivery);
            $templateVars['order-delivery-address'] = DeliveryHelper::getDeliveryAddress($order->id_delivery);
        }

        $noticeTemplate = static::processTemplate($template, $trigger, $templateVars);

        if ($noticeTemplate) {
            return static::sendMail($noticeTemplate->subj, $from, $to, $noticeTemplate->body, $attachments);
        }

        return false;
    }

    /**
     * @param $templateId
     * @param array $params
     * @return bool|null|Notice
     */
    protected static function processTemplate($templateId, $trigger, $params = [])
    {
        $template = Notice::findOne(['group'=>$templateId, 'status'=>Notice::STATUS_ENABLED, 'triger'=>$trigger]);

        if ($template) {
            $processedTemplate = null;

            foreach($params as $key => $value) {
                $template->subj = str_replace('{{'.$key.'}}', $value, $template->subj);
                $template->body = str_replace('{{'.$key.'}}', $value, $template->body);
                $processedTemplate = $template;
            }

            return $processedTemplate;
        }

        return false;
    }

    private static function sendMail($subject, array $from, $to, $body, $attachments)
    {
        $mailer = \Yii::$app->mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($body);

        foreach($attachments as $attachment) {
            list($content, $options) = $attachment;
            $mailer->attachContent($content, $options);
        }

        return $mailer->send();
    }
}