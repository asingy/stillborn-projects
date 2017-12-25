<?php

use backend\models\Order;
use common\components\Mailer;
use yii\db\Migration;

class m170926_155723_reorganize_mail_templates extends Migration
{
    public function up()
    {
        $templateBody = '<p> Добрый день, {{user-name}}!
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
                    <td>{{cliche-tpl}}<br>
                    </td>
                </tr>
                <tr>
                    <td>Оснастка<br>
                    </td>
                    <td>{{stamp}}<br>
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
                </p>';

        $this->alterColumn('{{%notice}}', 'status', $this->boolean()->notNull()->defaultValue(true));
        $this->addColumn('{{%notice}}', 'group', $this->boolean()->notNull()->defaultValue(true));
        $this->dropColumn('{{%notice}}', 'user');

        $this->truncateTable('{{%notice}}');

        $this->createIndex('idx_triger_group_unique', '{{%notice}}', [
            'triger',
            'group'
        ], true);

        $this->insert('{{%notice}}', [
            'id' => 1,
            'subj' => 'Новый заказ №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_NEW,
            'group' => Mailer::TEMPLATE_USER,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 2,
            'subj' => 'Истечение расчетной даты готовности заказа №{{order-id}}',
            'body' => $templateBody,
            'group' => Mailer::TEMPLATE_AGENT_AUTO,
            'triger' => null,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 3,
            'subj' => 'Агенту №{{order-id}}',
            'body' => $templateBody,
            'group' => Mailer::TEMPLATE_AGENT,
            'triger' => Order::STATUS_NEW,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 4,
            'subj' => 'Письмо производителю №{{order-id}}',
            'body' => $templateBody,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'triger' => Order::STATUS_PAID,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 5,
            'subj' => 'Ваш заказ подтвержден №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_ORDER,
            'group' => Mailer::TEMPLATE_USER,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 6,
            'subj' => 'Заказ оплачен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_PAID,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 7,
            'subj' => 'Заказ готов №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_DONE,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 8,
            'subj' => 'Заказ закрыт №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CLOSE,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 9,
            'subj' => 'Заказ отменен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CANCEL,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 10,
            'subj' => 'Срок действия заказа №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_EXPIRED,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 11,
            'subj' => 'Заказ оплачен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CASHLESS,
            'group' => Mailer::TEMPLATE_USER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 12,
            'subj' => 'Ваш заказ подтвержден №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_ORDER,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 13,
            'subj' => 'Заказ оплачен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_PAID,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 14,
            'subj' => 'Заказ готов №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_DONE,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 15,
            'subj' => 'Заказ закрыт №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CLOSE,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 16,
            'subj' => 'Заказ отменен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CANCEL,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 17,
            'subj' => 'Срок действия заказа №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_EXPIRED,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 18,
            'subj' => 'Заказ оплачен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CASHLESS,
            'group' => Mailer::TEMPLATE_AGENT,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 19,
            'subj' => 'Ваш заказ подтвержден №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_ORDER,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => true
        ]);

        $this->insert('{{%notice}}', [
            'id' => 20,
            'subj' => 'Заказ готов №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_DONE,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 21,
            'subj' => 'Новый заказ №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_NEW,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 22,
            'subj' => 'Заказ закрыт №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CLOSE,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 23,
            'subj' => 'Заказ отменен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CANCEL,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 24,
            'subj' => 'Срок действия заказа №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_EXPIRED,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);

        $this->insert('{{%notice}}', [
            'id' => 25,
            'subj' => 'Заказ оплачен №{{order-id}}',
            'body' => $templateBody,
            'triger' => Order::STATUS_CASHLESS,
            'group' => Mailer::TEMPLATE_MANUFACTURER,
            'status' => false
        ]);
    }

    public function down()
    {
        $this->dropIndex('idx_triger_group_unique', '{{%notice}}');
        $this->dropColumn('{{%notice}}', 'group');
        $this->addColumn('{{%notice}}', 'user', $this->integer());

        require_once (__DIR__.DIRECTORY_SEPARATOR.'m170919_124029_data_mail_tempaltes.php');
        $oldMigration = new m170919_124029_data_mail_tempaltes();
        $oldMigration->up();
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
