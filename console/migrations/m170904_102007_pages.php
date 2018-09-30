<?php

use yii\db\Migration;

class m170904_102007_pages extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_list}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'alias' => $this->string(32),
            'css_class' => $this->string(16),
            'meta_title' => $this->string(32),
            'meta_description' => $this->string(128),
            'meta_keywords' => $this->string(64),

        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%page_list}}');
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
