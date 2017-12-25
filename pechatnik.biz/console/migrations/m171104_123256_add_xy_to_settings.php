<?php

use yii\db\Migration;

class m171104_123256_add_xy_to_settings extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template_settings}}', 'x', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'y', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'mirror', $this->boolean()->notNull()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%template_settings}}', 'x');
        $this->dropColumn('{{%template_settings}}', 'y');
        $this->dropColumn('{{%template_settings}}', 'mirror');
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
