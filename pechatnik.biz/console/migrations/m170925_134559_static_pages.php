<?php

use yii\db\Migration;

class m170925_134559_static_pages extends Migration
{
    public function up()
    {
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text(),
            'meta_title' => $this->string()->defaultValue(null),
            'meta_keywords' => $this->string()->defaultValue(null),
            'meta_description' => $this->string()->defaultValue(null),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()
        ]);

        $this->createIndex('idx_pages_slug_unique', '{{%pages}}', 'slug', true);
    }

    public function down()
    {
        $this->dropIndex('idx_pages_slug_unique', '{{%pages}}');
        $this->dropTable('{{%pages}}');
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
