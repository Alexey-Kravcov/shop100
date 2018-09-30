<?php

use yii\db\Migration;

class m170316_174702_shop_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%buyer_group}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'description' => $this->string(255),
            'sort' => $this->integer(6),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions );

        $this->createTable('{{%buyer_assign}}',[
            'buyer_group' => $this->integer(11),
            'user_id' => $this->integer(11),
            'FOREIGN KEY (buyer_group) REFERENCES {{%buyer_group}} (id)',
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
        ], $tableOptions );

        $this->createTable('{{%price}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'description' => $this->string(255),
            'sort' => $this->integer(6),
            'base' => $this->integer(2),
            'ratio' => $this->integer(6),
            'show_group_id' => $this->integer(6),
            'buy_group_id' => $this->integer(6),
            'FOREIGN KEY (show_group_id) REFERENCES {{%buyer_group}} (id)',
            'FOREIGN KEY (buy_group_id) REFERENCES {{%buyer_group}} (id)',
        ], $tableOptions );

        $this->createTable('{{%price_assign}}',[
            'product_id' => $this->integer(11),
            'price_id' => $this->integer(11),
            'FOREIGN KEY (product_id) REFERENCES {{%product_element}} (id)',
            'FOREIGN KEY (price_id) REFERENCES {{%price}} (id)',
        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%price_assign}}');
        $this->dropTable('{{%price}}');
        $this->dropTable('{{%buyer_assign}}');
        $this->dropTable('{{%buyer_group}}');

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
