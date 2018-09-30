<?php

namespace common\models\product;

use Yii;

/**
 * This is the model class for table "product_seo".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $element_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property ProductSection $section
 * @property ProductElement $element
 */
class ProductSeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'element_id'], 'integer'],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 256],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSection::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['element_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductElement::className(), 'targetAttribute' => ['element_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Section ID',
            'element_id' => 'Element ID',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(ProductSection::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(ProductElement::className(), ['id' => 'element_id']);
    }
}
