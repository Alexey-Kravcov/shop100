<?php

use yii\db\Migration;

class m170312_190251_products_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_images}}',[
            'id' => $this->primaryKey(),
            'path' => $this->string(128),
            'name' => $this->string(64),
            'extension' => $this->string(10),
            'user_id' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
        ], $tableOptions );

        $this->createTable('{{%product_property}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'code' => $this->string(32),
            'active' => $this->string(2),
            'sort' => $this->integer(6),
            'default_value' => $this->string(256),
            'property_type' => $this->string(3),
            'implement' => $this->string(10),
            'multiple' => $this->string(3),
            'filtrable' => $this->string(3),
            'required' => $this->string(3),
            'description' => $this->string(3),
        ], $tableOptions );

        $this->createTable('{{%product_property_value}}',[
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(11),
            'own' => $this->string(1),
            'property_id' => $this->integer(11),
            'multi_id' => $this->integer(11),
            'value' => $this->string(16777215),
            'description' => $this->string(256),
            'FOREIGN KEY (property_id) REFERENCES {{%product_property}} (id)',
        ], $tableOptions );

        $this->createTable('{{%product_section}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'code' => $this->string(32),
            'active' => $this->string(2),
            'sort' => $this->integer(6),
            'depth' => $this->integer(2),
            'parent' => $this->integer(6),
            'preview_image' => $this->integer(11),
            'preview_text' => $this->string(16777215),
            'user_id' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (preview_image) REFERENCES {{%product_images}} (id)',
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
        ], $tableOptions );

        $this->createTable('{{%product_element}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'code' => $this->string(32),
            'active' => $this->string(2),
            'sort' => $this->integer(6),
            'section_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'preview_picture' => $this->integer(11),
            'preview_text' => $this->string(16777215),
            'detail_picture' => $this->integer(11),
            'detail_text' => $this->string(16777215),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (section_id) REFERENCES {{%product_section}} (id)',
            'FOREIGN KEY (preview_picture) REFERENCES {{%product_images}} (id)',
            'FOREIGN KEY (detail_picture) REFERENCES {{%product_images}} (id)',
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
        ], $tableOptions );

        $this->createTable('{{%product_seo}}',[
            'id' => $this->primaryKey(),
            'section_id' => $this->integer(11),
            'element_id' => $this->integer(11),
            'meta_title' => $this->string(256),
            'meta_keywords' => $this->string(256),
            'meta_description' => $this->string(256),
            'FOREIGN KEY (section_id) REFERENCES {{%product_section}} (id)',
            'FOREIGN KEY (element_id) REFERENCES {{%product_element}} (id)',
        ], $tableOptions );

        $this->createTable('{{%product_property_enum}}',[
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(11),
            'code' => $this->string(64),
            'name' => $this->string(64),
            'by_default' => $this->string(3),
        ], $tableOptions );
    }

    public function down()
    {
        $this->dropTable('{{%product_property_enum}}');
        $this->dropTable('{{%product_seo}}');
        $this->dropTable('{{%product_element}}');
        $this->dropTable('{{%product_section}}');
        $this->dropTable('{{%product_property_value}}');
        $this->dropTable('{{%product_property}}');
        $this->dropTable('{{%product_images}}');

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
