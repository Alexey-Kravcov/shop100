<?php

use yii\db\Migration;

class m170424_155707_data_cell_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cell_type}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'sections' => $this->string(1),
            'sort' => $this->integer(6),
        ], $tableOptions );

        $this->createTable('{{%cell_item}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'active' => $this->boolean(),
            'sort' => $this->integer(6),
            'cell_type_id' => $this->integer(),
            'searchable' => $this->boolean(),
            'section_name' => $this->string(16),
            'sections_name' => $this->string(16),
            'element_name' => $this->string(16),
            'elements_name' => $this->string(16),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (cell_type_id) REFERENCES {{%cell_type}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_images}}',[
            'id' => $this->primaryKey(),
            'path' => $this->string(128),
            'name' => $this->string(32),
            'extension' => $this->string(6),
            'filesize' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_section}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'depth' => $this->integer(6),
            'parent' => $this->integer(),
            'cell_type_id' => $this->integer(),
            'cell_id' => $this->integer(),
            'preview_picture' => $this->integer(),
            'preview_text' => $this->text(),
            'active' => $this->boolean(),
            'sort' => $this->integer(6),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (cell_type_id) REFERENCES {{%cell_type}} (id)',
            'FOREIGN KEY (cell_id) REFERENCES {{%cell_item}} (id)',
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
            'FOREIGN KEY (preview_picture) REFERENCES {{%cell_images}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_element}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'active' => $this->boolean(),
            'sort' => $this->integer(6),
            'cell_type_id' => $this->integer(),
            'cell_id' => $this->integer(),
            'section_id' => $this->integer(),
            'user_id' => $this->integer(),
            'preview_picture' => $this->integer(),
            'preview_text' => $this->text(),
            'detail_picture' => $this->integer(),
            'detail_text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (cell_type_id) REFERENCES {{%cell_type}} (id)',
            'FOREIGN KEY (cell_id) REFERENCES {{%cell_item}} (id)',
            'FOREIGN KEY (section_id) REFERENCES {{%cell_section}} (id)',
            'FOREIGN KEY (user_id) REFERENCES {{%user}} (id)',
            'FOREIGN KEY (preview_picture) REFERENCES {{%cell_images}} (id)',
            'FOREIGN KEY (detail_picture) REFERENCES {{%cell_images}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_seo}}',[
            'id' => $this->primaryKey(),
            'section_id' => $this->integer(),
            'element_id' => $this->integer(),
            'meta_title' => $this->string(256),
            'meta_keywords' => $this->string(256),
            'meta_description' => $this->string(256),
            'FOREIGN KEY (section_id) REFERENCES {{%cell_section}} (id)',
            'FOREIGN KEY (element_id) REFERENCES {{%cell_element}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_property}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'active' => $this->boolean(),
            'sort' => $this->integer(6),
            'default_value' => $this->string(256),
            'property_type' => $this->string(3),
            'cell_id' => $this->integer(),
            'own' => $this->string(10),
            'multiple' => $this->boolean(),
            'filtrable' => $this->boolean(),
            'required' => $this->boolean(),
            'description' => $this->boolean(),
        ], $tableOptions );

        $this->createTable('{{%cell_property_value}}',[
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(),
            'property_id' => $this->integer(),
            'multi_id' => $this->integer(3),
            'value' => $this->text(),
            'description' => $this->string(256),
            'FOREIGN KEY (property_id) REFERENCES {{%cell_property}} (id)',
        ], $tableOptions );

        $this->createTable('{{%cell_property_enum}}',[
            'id' => $this->primaryKey(),
            'property_id' => $this->integer(),
            'name' => $this->string(32),
            'code' => $this->string(32),
            'by_default' => $this->boolean(),
            'FOREIGN KEY (property_id) REFERENCES {{%cell_property}} (id)',
        ], $tableOptions );

    }

    public function down()
    {
        $this->dropTable('{{%cell_property_enum}}');
        $this->dropTable('{{%cell_property_value}}');
        $this->dropTable('{{%cell_property}}');
        $this->dropTable('{{%cell_seo}}');
        $this->dropTable('{{%cell_element}}');
        $this->dropTable('{{%cell_section}}');
        $this->dropTable('{{%cell_images}}');
        $this->dropTable('{{%cell_item}}');
        $this->dropTable('{{%cell_type}}');

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
