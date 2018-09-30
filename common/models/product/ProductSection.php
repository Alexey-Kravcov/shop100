<?php

namespace common\models\product;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\users\User;

/**
 * This is the model class for table "product_section".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $sort
 * @property integer $depth
 * @property integer $parent
 * @property integer $preview_image
 * @property string $preview_text
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductElement[] $productElements
 * @property ProductImages $previewImage
 * @property User $user
 */
class ProductSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_section';
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
            [['sort', 'depth', 'parent', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['code'], 'string', 'max' => 32],
            [['active'], 'string', 'max' => 2],
            [['preview_text'], 'string'],
            //[['preview_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['preview_image'], 'exist', 'skipOnError' => true, 'targetClass' => ProductImages::className(), 'targetAttribute' => ['preview_image' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'active' => 'Активен',
            'sort' => 'Сортировка',
            'depth' => 'Depth',
            'parent' => 'Parent',
            'preview_image' => 'Картинка раздела',
            'preview_text' => 'Описание раздела',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductElements()
    {
        return $this->hasMany(ProductElement::className(), ['section_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviewImage()
    {
        return $this->hasOne(ProductImages::className(), ['id' => 'preview_image']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSectionProperty($sectionsData){
        
    }
}
