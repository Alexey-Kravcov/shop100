<?php

namespace common\models\menu;

use Yii;

/**
 * This is the model class for table "menu_assign".
 *
 * @property integer $id
 * @property integer $menu_group
 * @property integer $menu_item
 *
 * @property MenuGroup $menuGroup
 * @property MenuItem $menuItem
 */
class MenuAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_group', 'menu_item', 'position'], 'integer'],
            [['menu_group'], 'exist', 'skipOnError' => true, 'targetClass' => MenuGroup::className(), 'targetAttribute' => ['menu_group' => 'id']],
            [['menu_item'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['menu_item' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_group' => 'Menu Group',
            'menu_item' => 'Menu Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuGroup()
    {
        return $this->hasOne(MenuGroup::className(), ['id' => 'menu_group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'menu_item']);
    }
}
