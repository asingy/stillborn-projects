<?php

use yii\db\Migration;

class m171012_160918_update_cliche_fields_19 extends Migration
{
    public function up()
    {
        $model = \backend\models\ClicheTpl::findOne(19);
        $model->fields = '[{"field":"ogrn_ip","name":"\u041e\u0413\u0420\u041d\u0418\u041f"},{"field":"inn_ip","name":"\u0418\u041d\u041d"},{"field":"city","name":"\u0413\u043e\u0440\u043e\u0434"},{"field":"fio","name":"\u0424\u0430\u043c\u0438\u043b\u0438\u044f \u0418\u043c\u044f \u041e\u0442\u0447\u0435\u0441\u0442\u0432\u043e"}]';
        $model->update();
    }

    public function down()
    {
        echo "m171012_160918_update_cliche_fields_19 cannot be reverted.\n";

        return true;
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
