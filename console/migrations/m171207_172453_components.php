<?php

use yii\db\Migration;

class m171207_172453_components extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%component_groups}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'sort' => $this->integer(3),
            'description' => $this->string(256),
        ], $tableOptions );

        $this->createTable('{{%component_list}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'sort' => $this->integer(3),
            'group_id' => $this->integer(3),
            'description' => $this->string(256),
            'params' => $this->text(),
            'FOREIGN KEY (group_id) REFERENCES {{%component_groups}} (id)',
        ], $tableOptions );

        $this->createTable('{{%component_apply}}',[
            'id' => $this->primaryKey(),
            'component_id' => $this->integer(3),
            'part' => $this->string(10),
            'position' => $this->integer(3),
            'params' => $this->text(),
            'FOREIGN KEY (component_id) REFERENCES {{%component_list}} (id)',
        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%component_apply}}');
        $this->dropTable('{{%component_list}}');
        $this->dropTable('{{%component_groups}}');
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
