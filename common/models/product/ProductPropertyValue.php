<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "product_property_value".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property integer $property_id
 * @property string $value
 * @property string $description
 *
 * @property ProductProperty $property
 */
class ProductPropertyValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_property_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'property_id'], 'integer'],
            [['value'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 255],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductProperty::className(), 'targetAttribute' => ['property_id' => 'id']],
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
            'value' => 'Value',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(ProductProperty::className(), ['id' => 'property_id']);
    }
}
