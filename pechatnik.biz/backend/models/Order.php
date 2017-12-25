<?php

namespace backend\models;

use common\components\Mailer;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $number
 * @property integer $id_client
 * @property integer $id_producer
 * @property integer $id_stamp
 * @property integer $id_payment
 * @property string $id_emoney
 * @property integer $quantity
 * @property integer $stamp_inn
 * @property string $stamp_ogrn
 * @property string $stamp_org_name
 * @property string $stamp_org_address
 * @property integer $status
 * @property integer $cost
 * @property integer $id_city
 * @property string $date
 * @property string $date_close
 * @property string $delivery_address
 * @property string $svg
 * @property string $png
 * @property string $scans
 * @property Client $client
 * @property Stamp $stamp
 * @property Producer $producer
 * @property ClicheTpl $cliche_tpl
 * @property Payment $payment
 * @property City $city
 * @property User $user
 * @property AgentProducer $agent_producer
 * @property UploadedFile $scansFile
 * @property ClicheSize $clicheSize
 */
class Order extends \yii\db\ActiveRecord
{
    public $scansFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function init()
    {
        parent::init();

        $this->on(self::EVENT_STATUS_NEW, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_NEW]);
        $this->on(self::EVENT_STATUS_ORDER, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_ORDER]);
        $this->on(self::EVENT_STATUS_PAID, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_PAID]);
        $this->on(self::EVENT_STATUS_DONE, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_DONE]);
        $this->on(self::EVENT_STATUS_CLOSE, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_CLOSE]);
        $this->on(self::EVENT_STATUS_CANCEL, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_CANCEL]);
        $this->on(self::EVENT_STATUS_EXPIRED, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_EXPIRED]);
        $this->on(self::EVENT_STATUS_CASHLESS, [Mailer::class, 'sendMessage'], ['type'=>self::STATUS_CASHLESS]);
    }

    const STATUS_NEW = 0;
    const STATUS_ORDER = 1;
    const STATUS_PAID = 2;
    const STATUS_DONE = 3;
    const STATUS_CLOSE = 4;
    const STATUS_CANCEL = 5;
    const STATUS_EXPIRED = 6;
    const STATUS_CASHLESS = 7;

    const EVENT_STATUS_NEW = 'order_status_new';
    const EVENT_STATUS_ORDER = 'order_status_order';
    const EVENT_STATUS_PAID = 'order_status_paid';
    const EVENT_STATUS_DONE = 'order_status_done';
    const EVENT_STATUS_CLOSE = 'order_status_close';
    const EVENT_STATUS_CANCEL = 'order_status_cancel';
    const EVENT_STATUS_EXPIRED = 'order_status_expired';
    const EVENT_STATUS_CASHLESS = 'order_status_cashless';

    public static $cliche_fields = [
      1 => ['name', 'spec', 'text'],
      2 => ['inn', 'ogrn', 'name', 'city'],
      3 => ['text', 'text_tpl'],
      4 => ['name', 'ogrn', 'text', 'text_tpl'],
    ];

    public static $statusMapping = [
        self::STATUS_NEW => self::EVENT_STATUS_NEW,
        self::STATUS_ORDER => self::EVENT_STATUS_ORDER,
        self::STATUS_PAID => self::EVENT_STATUS_PAID,
        self::STATUS_DONE => self::EVENT_STATUS_DONE,
        self::STATUS_CLOSE => self::EVENT_STATUS_CLOSE,
        self::STATUS_CANCEL => self::EVENT_STATUS_CANCEL,
        self::STATUS_EXPIRED => self::EVENT_STATUS_EXPIRED,
        self::STATUS_CASHLESS => self::EVENT_STATUS_CASHLESS
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number','id_client', 'id_producer', 'id_cliche_tpl', 'id_stamp','id_payment', 'quantity', 'cost', 'id_delivery', 'delivery_address', 'id_user', 'id_cliche_size'], 'required'],
            [['id_client', 'id_producer', 'id_stamp', 'id_cliche_tpl','id_payment', 'quantity', 'status', 'cost', 'id_city', 'id_delivery', 'id_user', 'number'], 'integer'],
            [['delivery_address', 'info', 'payment_person', 'payment_inn', 'payment_address', 'svg', 'scans'], 'string'],
            [['date', 'date_close', 'scansFile'], 'safe'],
            [['scansFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, doc, docx, pdf, svg, rtf', 'maxFiles' => 1],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'id_client' => 'Клиент',
            'id_producer' => 'Изготовитель',
            'id_cliche_tpl' => 'Макет печати',
            'id_cliche_size' => 'Размер печати',
            'id_stamp' => 'Оснастка',
            'id_payment' => 'Способ оплаты',
            'id_delivery' => 'Способ получения',
            'quantity' => 'Кол-во',
            'status' => 'Статус',
            'cost' => 'Сумма р.',
            'payment_person' => 'Плательщик',
            'payment_inn' => 'ИНН плательщика',
            'payment_address' => 'Адрес плательщика',
            'id_city' => 'Город',
            'date' => 'Дата',
            'date_close' => 'Дата выдачи',
            'delivery_address' => 'Адрес получения',
            'info' => 'Инфо',
            'id_user' => 'Создатель',
            'scans' => 'Сканы документов',
        ];
    }

    public function getClient()
    {
      return $this->hasOne(Client::className(), ['id' => 'id_client']);
    }

    public function getStamp()
    {
      return $this->hasOne(Stamp::className(), ['id' => 'id_stamp']);
    }

    public function getProducer()
    {
      return $this->hasOne(Producer::className(), ['id' => 'id_producer']);
    }

    public function getCliche_tpl()
    {
      return $this->hasOne(ClicheTpl::className(), ['id' => 'id_cliche_tpl']);
    }

    public function getPayment()
    {
      return $this->hasOne(Payment::className(), ['id' => 'id_payment']);
    }

    public function getCity()
    {
      return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    public function getUser()
    {
      return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getAgent_producer()
    {
      return $this->hasOne(AgentProducer::className(), ['id_producer' => 'id_producer']);
    }

    public function getClicheSize()
    {
        return $this->hasOne(ClicheSize::className(), ['id' => 'id_cliche_size']);
    }

}
