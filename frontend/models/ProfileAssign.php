<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "profile_assign".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $gender_id
 * @property integer $image_id
 */
class ProfileAssign extends \yii\db\ActiveRecord
{
    /*public $user_id;
    public $gender_id;
    public $image_id;*/
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'gender_id', 'image_id'], 'required'],
            [['id', 'user_id', 'gender_id', 'image_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'gender_id' => 'Gender ID',
            'image_id' => 'Image ID',
        ];
    }
}
