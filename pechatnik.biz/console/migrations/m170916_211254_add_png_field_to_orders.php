<?php

use yii\db\Migration;

class m170916_211254_add_png_field_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn('{{%order}}', 'png', $this->binary());
    }

    public function down()
    {
        $this->dropColumn('{{%order}}', 'png');
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
