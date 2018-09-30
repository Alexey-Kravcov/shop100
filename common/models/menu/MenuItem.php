<?php

namespace common\models\menu;

use Yii;

/**
 * This is the model class for table "menu_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $parent
 * @property integer $sort
 * @property string $css_class
 * @property string $attributes
 *
 * @property MenuAssign[] $menuAssigns
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'sort'], 'integer'],
            [['attributes'], 'string'],
            [['name', 'code', 'css_class'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Символьный код',
            'link' => 'Адрес ссылки',
            'parent' => 'Родительский пункт',
            'sort' => 'Сортировка',
            'css_class' => 'Css класс для пункта',
            'attributes' => 'Аттрибуты',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuAssigns()
    {
        return $this->hasMany(MenuAssign::className(), ['menu_item' => 'id']);
    }
}
