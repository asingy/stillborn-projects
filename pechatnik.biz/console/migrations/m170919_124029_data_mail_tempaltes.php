<?php

use backend\models\Order;
use yii\db\Migration;

class m170919_124029_data_mail_tempaltes extends Migration
{
    public function up()
    {
        $this->down();

        $this->alterColumn('{{%notice}}', 'triger', $this->integer()->null());

        $this->insert('{{%notice}}', [
            'id' => 1,
            'subj' => 'Новый заказ №{{order-id}}',
            'body' => '<p> Добрый день, {{user-name}}!
                </p><p> Спасибо, что воспользовались сервисом ПЕЧАТНИК Если вам не перезвонили в течение 30 минут, пожалуйста сообщите нам об этом по телефону:
                </p><p> Ваш заказ {{order-number}} от {{order-date}}
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Имя<br>
                    </td>
                    <td>{{user-name}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>{{user-email}}
                    </td>
                </tr>
                <tr>
                    <td>Телефон<br>
                    </td>
                    <td>{{user-phone}}
                    </td>
                </tr>
                </tbody>
                </table><p> Параметры заказа
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Тип печати<br>
                    </td>
                    <td>{{cliche}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Макет<br>
                    </td>
                    <td><img src="{{cliche-tpl}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Оснастка<br>
                    </td>
                    <td><img src="{{stamp}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Размер<br>
                    </td>
                    <td>{{cliche-size}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Количество<br>
                    </td>
                    <td>{{order-qty}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ получения<br>
                    </td>
                    <td>{{order-delivery}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Адрес получения<br>
                    </td>
                    <td>{{order-delivery-address}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ оплаты<br>
                    </td>
                    <td>{{order-payment}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Стоимость<br>
                    </td>
                    <td>{{order-cost}}<br>
                    </td>
                </tr>
                </tbody>
                </table><p> <a href="http://pechatnik.ru/"><u>pechatnik.ru</u></a>
                </p>',
            'triger' => Order::STATUS_NEW,
            'user' => '1',
            'status' => '0'
        ]);

        $this->insert('{{%notice}}', [
            'id' => 2,
            'subj' => 'Истечение расчетной даты готовности заказа №{{order-id}}',
            'body' => '<p> Добрый день, {{user-name}}!
                </p><p> Спасибо, что воспользовались сервисом ПЕЧАТНИК Если вам не перезвонили в течение 30 минут, пожалуйста сообщите нам об этом по телефону:
                </p><p> Ваш заказ {{order-number}} от {{order-date}}
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Имя<br>
                    </td>
                    <td>{{user-name}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>{{user-email}}
                    </td>
                </tr>
                <tr>
                    <td>Телефон<br>
                    </td>
                    <td>{{user-phone}}
                    </td>
                </tr>
                </tbody>
                </table><p> Параметры заказа
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Тип печати<br>
                    </td>
                    <td>{{cliche}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Макет<br>
                    </td>
                    <td><img src="{{cliche-tpl}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Оснастка<br>
                    </td>
                    <td><img src="{{stamp}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Размер<br>
                    </td>
                    <td>{{cliche-size}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Количество<br>
                    </td>
                    <td>{{order-qty}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ получения<br>
                    </td>
                    <td>{{order-delivery}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Адрес получения<br>
                    </td>
                    <td>{{order-delivery-address}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ оплаты<br>
                    </td>
                    <td>{{order-payment}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Стоимость<br>
                    </td>
                    <td>{{order-cost}}<br>
                    </td>
                </tr>
                </tbody>
                </table><p> <a href="http://pechatnik.ru/"><u>pechatnik.ru</u></a>
                </p>',
            'triger' => null,
            'user' => '2',
            'status' => '0'
        ]);

        $this->insert('{{%notice}}', [
            'id' => 3,
            'subj' => 'Агенту №{{order-id}}',
            'body' => '<p> Добрый день, {{user-name}}!
                </p><p> Спасибо, что воспользовались сервисом ПЕЧАТНИК Если вам не перезвонили в течение 30 минут, пожалуйста сообщите нам об этом по телефону:
                </p><p> Ваш заказ {{order-number}} от {{order-date}}
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Имя<br>
                    </td>
                    <td>{{user-name}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>{{user-email}}
                    </td>
                </tr>
                <tr>
                    <td>Телефон<br>
                    </td>
                    <td>{{user-phone}}
                    </td>
                </tr>
                </tbody>
                </table><p> Параметры заказа
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Тип печати<br>
                    </td>
                    <td>{{cliche}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Макет<br>
                    </td>
                    <td><img src="{{cliche-tpl}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Оснастка<br>
                    </td>
                    <td><img src="{{stamp}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Размер<br>
                    </td>
                    <td>{{cliche-size}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Количество<br>
                    </td>
                    <td>{{order-qty}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ получения<br>
                    </td>
                    <td>{{order-delivery}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Адрес получения<br>
                    </td>
                    <td>{{order-delivery-address}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ оплаты<br>
                    </td>
                    <td>{{order-payment}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Стоимость<br>
                    </td>
                    <td>{{order-cost}}<br>
                    </td>
                </tr>
                </tbody>
                </table><p> <a href="http://pechatnik.ru/"><u>pechatnik.ru</u></a>
                </p>',
            'triger' => Order::STATUS_NEW,
            'user' => '3',
            'status' => '0'
        ]);

        $this->insert('{{%notice}}', [
            'id' => 4,
            'subj' => 'Письмо производителю №{{order-id}}',
            'body' => '<p> Добрый день, {{user-name}}!
                </p><p> Спасибо, что воспользовались сервисом ПЕЧАТНИК Если вам не перезвонили в течение 30 минут, пожалуйста сообщите нам об этом по телефону:
                </p><p> Ваш заказ {{order-number}} от {{order-date}}
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Имя<br>
                    </td>
                    <td>{{user-name}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Email
                    </td>
                    <td>{{user-email}}
                    </td>
                </tr>
                <tr>
                    <td>Телефон<br>
                    </td>
                    <td>{{user-phone}}
                    </td>
                </tr>
                </tbody>
                </table><p> Параметры заказа
                </p><table style="width:50%">
                <tbody>
                <tr>
                    <td>Тип печати<br>
                    </td>
                    <td>{{cliche}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Макет<br>
                    </td>
                    <td><img src="{{cliche-tpl}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Оснастка<br>
                    </td>
                    <td><img src="{{stamp}}" alt=""><br>
                    </td>
                </tr>
                <tr>
                    <td>Размер<br>
                    </td>
                    <td>{{cliche-size}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Количество<br>
                    </td>
                    <td>{{order-qty}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ получения<br>
                    </td>
                    <td>{{order-delivery}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Адрес получения<br>
                    </td>
                    <td>{{order-delivery-address}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Способ оплаты<br>
                    </td>
                    <td>{{order-payment}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Стоимость<br>
                    </td>
                    <td>{{order-cost}}<br>
                    </td>
                </tr>
                </tbody>
                </table><p> <a href="http://pechatnik.ru/"><u>pechatnik.ru</u></a>
                </p>',
            'triger' => Order::STATUS_PAID,
            'user' => '4',
            'status' => '0'
        ]);
    }

    public function down()
    {
        $this->truncateTable('{{%notice}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
