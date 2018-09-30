<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "product_property_enum".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $code
 * @property string $name
 * @property string $by_default
 */
class ProductPropertyEnum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_property_enum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id'], 'integer'],
            [['code', 'name'], 'string', 'max' => 64],
            [['by_default'], 'number', 'max' => 3],
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
            'code' => 'Символьный код',
            'name' => 'Название',
            'by_default' => 'By Default',
        ];
    }
    static function getEditRowEnum($i, $enumAttr, $checked) {
        echo '<div class="row">
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
    }
}
