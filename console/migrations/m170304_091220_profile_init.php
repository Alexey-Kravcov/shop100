<?php

use yii\db\Migration;

class m170304_091220_profile_init extends Migration
{
    public function up()
    {
        /** @var TYPE_NAME $tableOptions */
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%profile_images}}', [
            'id' => $this->primaryKey(),
            'base_name' => $this->string(64),
            'extension' => $this->string(32),
            'img_width' => $this->integer(),
            'img_height' => $this->integer(),
        ],$tableOptions);

        $this->createTable('{{%profile_genders}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32)->unique(),
            'description' => $this->string(256),
        ],$tableOptions);
        
        $this->createTable('{{%profile}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'birthday' => $this->string(32),
            'gender' => $this->integer(),
            'phone' => $this->string(32),
            'image' => $this->integer(),
            'status' => $this->string(256),
            'address' => $this->string(256),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (image) REFERENCES {{%profile_images}} (id)',
            'FOREIGN KEY (gender) REFERENCES {{%profile_genders}} (id)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%profile_genders}}');
        $this->dropTable('{{%profile_images}}');
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
