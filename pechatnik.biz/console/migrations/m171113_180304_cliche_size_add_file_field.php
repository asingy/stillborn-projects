<?php

use yii\db\Migration;

class m171113_180304_cliche_size_add_file_field extends Migration
{
    public function up()
    {
        $this->addColumn('cliche_size', 'image', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn('cliche_size', 'image');
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
