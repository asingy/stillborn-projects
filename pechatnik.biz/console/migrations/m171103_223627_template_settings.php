<?php

use yii\db\Migration;

class m171103_223627_template_settings extends Migration
{
    public function up()
    {
        $this->createTable('{{%template_settings}}', [
            'id' => $this->primaryKey()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'field' => $this->string()->notNull(),
            'radius' => $this->float()->notNull(),
            'start' => $this->float()->notNull(),
            'end' => $this->float()->notNull(),
            'inner' => $this->boolean()->notNull()->defaultValue(false),
            'selector' => $this->string()->notNull(),
            'prefix' => $this->string(),
        ]);

        $this->addForeignKey('fk_template_settings_cliche_tpl', '{{%template_settings}}', 'template_id', 'cliche_tpl', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_template_settings_cliche_tpl', '{{%template_settings}}');

        $this->dropTable('{{%template_settings}}');
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
