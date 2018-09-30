<?php

namespace common\models\cell;

use Yii;

/**
 * This is the model class for table "cell_property_enum".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $name
 * @property string $code
 * @property integer $by_default
 *
 * @property CellProperty $property
 */
class CellPropertyEnum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_property_enum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'by_default'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
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
            'property_id' => 'Property ID',
            'name' => 'Name',
            'code' => 'Code',
            'by_default' => 'By Default',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(CellProperty::className(), ['id' => 'property_id']);
    }

    public function getEditRowEnum($i, $enumAttr, $checked) {
        $row = '<div class="row">
                  <input type="hidden" name="property-enum['.$i.'][id]" value="'.$enumAttr['id'].'" />
                      <div class="col-md-3">
                          <input type="text" name="property-enum['.$i.'][code]" class="number-input" value="'.$enumAttr['code'].'" />
                      </div>
                      <div class="col-md-6">
                          <input type="text" name="property-enum['.$i.'][name]" class="text-input" value="'.$enumAttr['name'].'" />
                      </div>
                      <div class="col-md-3 center">
                          <input type="checkbox" name="property-enum['.$i.'][by_default]" value="1" class="by_default" '.$checked.' />
                      </div>
              </div>';

        return $row;
    }

    public function getEnumArray($arPropertyKeys) {
        $arEnum = CellPropertyEnum::find()
            ->where(['property_id'=>$arPropertyKeys])
            ->all();
        $result = [];
        foreach($arEnum as $enum) {
            $result[$enum['property_id']][] = $enum;
        }
        return $result;
    }
    
}
