<?php

use yii\db\Migration;

class m170919_121707_add_sended_field_to_order extends Migration
{
    public function up()
    {
        $this->addColumn('{{%order}}', 'sended', $this->boolean()->notNull()->defaultValue(false));
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
