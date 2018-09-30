<?php

use yii\db\Migration;

class m170513_163828_main_settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%main_settings}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'value' => $this->string(64),

        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%main_settings}}');
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
