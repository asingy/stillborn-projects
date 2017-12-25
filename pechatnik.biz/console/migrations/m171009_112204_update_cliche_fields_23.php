<?php

use yii\db\Migration;

class m171009_112204_update_cliche_fields_23 extends Migration
{
    public function up()
    {
        $model = \backend\models\ClicheTpl::findOne(23);
        $model->fields = '[
            {
                "field":"name",
                "name":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435"
            },
            {
                "field":"city",
                "name":"\u0413\u043e\u0440\u043e\u0434"
            }
        ]';
        $model->update();
    }

    public function down()
    {
        echo "m171009_112204_update_cliche_fields_23 cannot be reverted.\n";

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
