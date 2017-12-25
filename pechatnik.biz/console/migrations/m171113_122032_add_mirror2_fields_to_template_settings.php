<?php

use yii\db\Migration;

class m171113_122032_add_mirror2_fields_to_template_settings extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template_settings}}', 'radius_mirror2', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'start_mirror2', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'end_mirror2', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'mirror2', $this->boolean()->notNull()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%template_settings}}', 'radius_mirror2');
        $this->dropColumn('{{%template_settings}}', 'start_mirror2');
        $this->dropColumn('{{%template_settings}}', 'end_mirror2');
        $this->dropColumn('{{%template_settings}}', 'mirror2');
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
