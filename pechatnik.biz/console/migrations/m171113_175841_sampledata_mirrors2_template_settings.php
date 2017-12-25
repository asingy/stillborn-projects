<?php

use yii\db\Migration;

class m171113_175841_sampledata_mirrors2_template_settings extends Migration
{
    public function up()
    {
        $this->truncateTable('{{%template_settings}}');

        $this->execute('INSERT INTO `template_settings` (`id`, `template_id`, `field`, `radius`, `start`, `end`, `inner`, `selector`, `prefix`, `x`, `y`, `mirror`, `radius_mirror`, `start_mirror`, `end_mirror`, `radius_mirror2`, `start_mirror2`, `end_mirror2`, `mirror2`)
                        VALUES
                            (1,5,\'city\',76,-79.5,115,0,\'RangText12,RangText14\',\'РОССИЙСКАЯ ФЕДЕРАЦИЯ ГОРОД\',125.8,125.8,1,84.5,79,107.5,NULL,NULL,NULL,0),
                            (2,5,\'inn_ip\',113,-142,31,0,\'RangText5,RangText3\',\'ИНН\',125.8,125.8,1,120.5,-82,33,NULL,NULL,NULL,0),
                            (3,5,\'ogrn_ip\',112.5,-239.5,38.5,0,\'RangText2,RangText10,RangText4\',\'ОГРНИН\',125.8,125.8,1,106.5,-283,72.5,123,-167.5,38.5,1);');
    }

    public function down()
    {
        $this->truncateTable('{{%template_settings}}');

        $this->execute('INSERT INTO `template_settings` (`id`, `template_id`, `field`, `radius`, `start`, `end`, `inner`, `selector`, `prefix`, `x`, `y`, `mirror`, `radius_mirror`, `start_mirror`, `end_mirror`)
                        VALUES
                        (1,5,\'city\',76,-79.5,115,0,\'RangText12,RangText14\',\'РОССИЙСКАЯ ФЕДЕРАЦИЯ ГОРОД\',125.8,125.8,1,84.5,79,107.5),
                        (2,5,\'inn_ip\',113,-142,31,0,\'RangText5,RangText3\',\'ИНН\',125.8,125.8,1,120.5,-82,33),
                        (3,5,\'ogrn_ip\',105,-283.5,71.5,1,\'RangText10\',\'ОГРНИН\',125.8,125.8,0,10,-360,-360)');
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
