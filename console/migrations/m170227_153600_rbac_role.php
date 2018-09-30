<?php

use yii\db\Migration;

class m170227_153600_rbac_role extends Migration
{
    /**
     *
     */
    public function up()
    {
        $rbac = \Yii::$app->authManager;

        $admin = $rbac->createRole('admin');
        $admin->description = 'Администратор с полными правами';
        $rbac->add($admin);

        $manager = $rbac->createRole('manager');
        $manager->description = 'Менеджер с правами работы с покупателями и товаром';
        $rbac->add($manager);

        $user = $rbac->createRole('user');
        $user->description = 'Зарегистрированный пользователь с правами доступа в личный кабинет';
        $rbac->add($user);

        $guest = $rbac->createRole('guest');
        $guest->description = 'Незарегистрированный пользователь';
        $rbac->add($guest);

        $rbac->addChild($admin, $manager);
        $rbac->addChild($manager, $user);
        $rbac->addChild($user, $guest);

        $create = $rbac->createPermission('create');
        $create->description = "Право на создание";
        $rbac->add($create);

        $read = $rbac->createPermission('read');
        $read->description = "Право на чтение";
        $rbac->add($read);

        $edit = $rbac->createPermission('edit');
        $edit->description = "Право на редактирование";
        $rbac->add($edit);

        $delete = $rbac->createPermission('delete');
        $delete->description = "Право на удаление";
        $rbac->add($delete);

        $rbac->addChild($guest, $read);
        $rbac->addChild($manager, $create);
        $rbac->addChild($manager, $edit);
        $rbac->addChild($admin, $delete);
        
        $rbac->assign($admin, 1);


    }

    public function down()
    {
        echo "m170227_153600_rbac_role cannot be reverted.\n";

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
