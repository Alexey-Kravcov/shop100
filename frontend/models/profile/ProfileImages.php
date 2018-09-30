<?php

namespace frontend\models\profile;

use Yii;

/**
 * This is the model class for table "profile_images".
 *
 * @property integer $id
 * @property string $base_name
 * @property string $extension
 * @property integer $img_width
 * @property integer $img_height
 *
 * @property Profile[] $profiles
 */
class ProfileImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_width', 'img_height'], 'integer'],
            [['base_name'], 'string', 'max' => 64],
            [['extension'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'base_name' => 'Base Name',
            'extension' => 'Extension',
            'img_width' => 'Img Width',
            'img_height' => 'Img Height',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['image' => 'id']);
    }
}
