<?php

use yii\db\Migration;

class m171105_131207_add_mirror_radius_angles extends Migration
{
    public function up()
    {
        $this->addColumn('{{%template_settings}}', 'radius_mirror', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'start_mirror', $this->float()->null());
        $this->addColumn('{{%template_settings}}', 'end_mirror', $this->float()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%template_settings}}', 'radius_mirror');
        $this->dropColumn('{{%template_settings}}', 'start_mirror');
        $this->dropColumn('{{%template_settings}}', 'end_mirror');
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
