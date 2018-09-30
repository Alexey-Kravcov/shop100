<?php

namespace common\models\cell;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cell_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $active
 * @property integer $sort
 * @property integer $cell_type_id
 * @property integer $searchable
 * @property string $section_name
 * @property string $sections_name
 * @property string $element_name
 * @property string $elements_name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CellElement[] $cellElements
 * @property CellType $cellType
 * @property CellSection[] $cellSections
 */
class CellItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_item';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'sort', 'cell_type_id', 'searchable', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
            [['section_name', 'sections_name', 'element_name', 'elements_name'], 'string', 'max' => 16],
            [['cell_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellType::className(), 'targetAttribute' => ['cell_type_id' => 'id']],
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
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'cell_type_id' => 'Cell Type ID',
            'searchable' => 'Участвовать в поиске',
            'section_name' => 'Название раздела',
            'sections_name' => 'Название разделов',
            'element_name' => 'Название элемента',
            'elements_name' => 'Название элементов',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellElements()
    {
        return $this->hasMany(CellElement::className(), ['cell_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellType()
    {
        return $this->hasOne(CellType::className(), ['id' => 'cell_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellSections()
    {
        return $this->hasMany(CellSection::className(), ['cell_id' => 'id']);
    }
}
