<?php

use yii\db\Migration;

class m170419_180418_menus_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu_item}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'link' => $this->string(32),
            'parent' => $this->integer(6),
            'sort' => $this->integer(6),
            'css_class' => $this->string(32),
            'attributes' => $this->text(),
        ], $tableOptions );

        $this->createTable('{{%menu_group}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'description' => $this->text(),
            'sort' => $this->integer(6),
            'css_class' => $this->string(32),
        ], $tableOptions );

        $this->createTable('{{%menu_assign}}',[
            'id' => $this->primaryKey(),
            'menu_group' => $this->integer(6),
            'menu_item' => $this->integer(6),
            'position' => $this->integer(6),
            'FOREIGN KEY (menu_group) REFERENCES {{%menu_group}} (id)',
            'FOREIGN KEY (menu_item) REFERENCES {{%menu_item}} (id)',
        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%menu_assign}}');
        $this->dropTable('{{%menu_group}}');
        $this->dropTable('{{%menu_item}}');

        return false;
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
