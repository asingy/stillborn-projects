<?php

use yii\db\Migration;

class m171113_222210_cliche_size_sample_data extends Migration
{
    public function up()
    {
        \backend\models\ClicheSize::updateAll(['image'=>'5a0a17513f9bf.svg'], ['id'=>6]);
    }

    public function down()
    {
        \backend\models\ClicheSize::updateAll(['image'=>null]);
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
