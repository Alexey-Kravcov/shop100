<?php

namespace common\models\menu;

use Yii;

/**
 * This is the model class for table "menu_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $sort
 * @property string $css_class
 *
 * @property MenuAssign[] $menuAssigns
 */
class MenuGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['name', 'code', 'css_class', 'link'], 'string', 'max' => 32],
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
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'css_class' => 'Css класс', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuAssigns()
    {
        return $this->hasMany(MenuAssign::className(), ['menu_group' => 'id']);
    }

    public function getMenuItems() {
        $models = self::find()->all();
        $result = [];
        $assignModels = MenuAssign::find()->all();
        foreach($assignModels as $assignModel) {
            $data = $assignModel->getAttributes();
            $assign[$data['menu_group']][$data['position']] = $data;
        }

        foreach($assign as &$item) {
            ksort($item);
        }

        foreach($models as $model){
            $result[] = [   'menu' => $model->getAttributes(),
                            'items' => $assign,
                        ];
        }
        return $result;
    }
}
