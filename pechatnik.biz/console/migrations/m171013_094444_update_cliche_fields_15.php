<?php

use yii\db\Migration;

class m171013_094444_update_cliche_fields_15 extends Migration
{
    public function up()
    {
        $model = \backend\models\ClicheTpl::findOne(15);
        $model->fields = '[{"field":"name","name":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435"},{"field":"inn_ooo","name":"\u0418\u041d\u041d"},{"field":"ogrn_ooo","name":"\u041e\u0413\u0420\u041d"},{"field":"city","name":"\u0413\u043e\u0440\u043e\u0434"}]';
        $model->update();
    }

    public function down()
    {
        echo "m171013_094444_update_cliche_fields_15 cannot be reverted.\n";

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
