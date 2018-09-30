<?php

namespace common\models\cell;

use Yii;

/**
 * This is the model class for table "cell_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $sections
 * @property integer $sort
 *
 * @property CellElement[] $cellElements
 * @property CellItem[] $cellItems
 * @property CellSection[] $cellSections
 */
class CellType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
            [['sections'], 'string', 'max' => 1],
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
            'sections' => 'Использовать разделы',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellElements()
    {
        return $this->hasMany(CellElement::className(), ['cell_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellItems()
    {
        return $this->hasMany(CellItem::className(), ['cell_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellSections()
    {
        return $this->hasMany(CellSection::className(), ['cell_type_id' => 'id']);
    }
    
}
