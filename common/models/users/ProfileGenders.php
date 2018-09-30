<?php

namespace common\models\users;

use Yii;

/**
 * This is the model class for table "profile_genders".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 *
 * @property Profile[] $profiles
 */
class ProfileGenders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_genders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 256],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['gender' => 'id']);
    }
}
