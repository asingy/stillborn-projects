<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Form is the model behind the form.
 */
class Create5Form extends Model
{
    public $name;
    public $address;
    public $phone;
    public $email;
    public $quantity;
    public $urgency;
    public $id_delivery;
    public $delivery_address;
    public $id_payment;
    public $payment_inn;
    public $payment_person;
    public $payment_address;
    public $id_emoney;
    public $scans;

    /**
     * @inheritdoc
     */
    function __construct($data = null)
    {
      if ($data !== null && is_array($data)) {
        // unset($data['_csrf-frontend']);
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
      }

    }
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'address', 'phone', 'quantity', 'id_delivery', 'delivery_address', 'id_payment', 'scans'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }


}
