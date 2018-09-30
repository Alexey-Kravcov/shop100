<?php

namespace common\models\cell;

use Yii;

/**
 * This is the model class for table "cell_property_value".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $property_id
 * @property integer $multi_id
 * @property string $value
 * @property string $description
 *
 * @property CellProperty $property
 */
class CellPropertyValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_property_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'property_id', 'multi_id'], 'integer'],
            [['value'], 'safe'],
            [['description'], 'string', 'max' => 256],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellProperty::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'property_id' => 'Property ID',
            'multi_id' => 'Multi ID',
            'value' => 'Value',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(CellProperty::className(), ['id' => 'property_id']);
    }

    public function getValues($ownerID, $arPropertyKeys) {
        $arValues = CellPropertyValue::find()
            ->where(['owner_id'=>$ownerID, 'property_id'=>$arPropertyKeys])
            ->indexBy('id')
            ->all();
        $result = [];
        foreach($arValues as $value) {
            $result[$value->property_id][$value->multi_id] = $value;
        }
        return $result;
    }

}
