<?php

use yii\db\Migration;

class m170919_164507_remove_sended_field_to_order extends Migration
{
    public function up()
    {
        $this->down();
    }

    public function down()
    {
        $this->dropColumn('{{%order}}', 'sended');
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
