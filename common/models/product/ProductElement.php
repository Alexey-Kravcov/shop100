<?php

namespace common\models\product;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\users\User;

/**
 * This is the model class for table "product_element".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $sort
 * @property integer $section_id
 * @property integer $user_id
 * @property integer $preview_picture
 * @property string $preview_text
 * @property integer $detail_picture
 * @property string $detail_text
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductSection $section
 * @property ProductImages $previewPicture
 * @property ProductImages $detailPicture
 * @property User $user
 */
class ProductElement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_element';
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
            [['sort', 'section_id', 'user_id', 'preview_picture', 'detail_picture', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['code'], 'string', 'max' => 32],
            [['active'], 'string', 'max' => 2],
            [['detail_text', 'preview_text'], 'string', ],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductSection::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['preview_picture'], 'exist', 'skipOnError' => true, 'targetClass' => ProductImages::className(), 'targetAttribute' => ['preview_picture' => 'id']],
            [['detail_picture'], 'exist', 'skipOnError' => true, 'targetClass' => ProductImages::className(), 'targetAttribute' => ['detail_picture' => 'id']],
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
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'section_id' => 'Section ID',
            'user_id' => 'User ID',
            'preview_picture' => 'Картинка для анонса',
            'preview_text' => 'Текст анонса',
            'detail_picture' => 'Детальная картинка',
            'detail_text' => 'Подробный текст',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getPreviewPicture()
    {
        return $this->hasOne(ProductImages::className(), ['id' => 'preview_picture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailPicture()
    {
        return $this->hasOne(ProductImages::className(), ['id' => 'detail_picture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
