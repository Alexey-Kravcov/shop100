<?php

namespace common\models\product;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\users\User;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property string $path
 * @property string $name
 * @property string $extension
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductElement[] $productElements
 * @property ProductElement[] $productElements0
 * @property User $user
 * @property ProductSection[] $productSections
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
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
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['path'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 64],
            [['extension'], 'string', 'max' => 10],
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
            'path' => 'Path',
            'name' => 'Name',
            'extension' => 'Extension',
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
        return $this->hasMany(ProductElement::className(), ['preview_picture' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductElements0()
    {
        return $this->hasMany(ProductElement::className(), ['detail_picture' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSections()
    {
        return $this->hasMany(ProductSection::className(), ['preview_image' => 'id']);
    }
}
