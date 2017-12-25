<?php

use yii\db\Migration;

class m171128_144510_change_id_emoney_to_string extends Migration
{
    public function up()
    {
        $this->alterColumn('order', 'id_emoney', $this->string());
    }

    public function down()
    {
        $this->alterColumn('order', 'id_emoney', $this->integer());
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
