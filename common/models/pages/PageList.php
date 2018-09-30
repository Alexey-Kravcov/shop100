<?php

namespace common\models\pages;

use Yii;

/**
 * This is the model class for table "page_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $alias
 * @property string $css_class
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class PageList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'alias', 'meta_title'], 'string', 'max' => 32],
            [['css_class'], 'string', 'max' => 16],
            [['meta_description'], 'string', 'max' => 128],
            [['meta_keywords'], 'string', 'max' => 64],
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
            'alias' => 'Алиас',
            'css_class' => 'Css класс',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }
}
