<?php

namespace frontend\models\profile;

use Yii;
use frontend\models\User;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $birthday
 * @property integer $gender
 * @property string $phone
 * @property integer $image
 * @property string $status
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property ProfileImages $image0
 * @property ProfileGenders $gender0
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender', 'image', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['birthday', 'phone'], 'string', 'max' => 32],
            [['status', 'address'], 'string', 'max' => 256],
            /*[['user_id'], 'unique'],*/
            /*[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['image'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileImages::className(), 'targetAttribute' => ['image' => 'id']],
            [['gender'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileGenders::className(), 'targetAttribute' => ['id']],*/
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
            'name' => 'Name',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'image' => 'Image',
            'status' => 'Status',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(frontend\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage0()
    {
        return $this->hasOne(ProfileImages::className(), ['id' => 'image']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender0()
    {
        return $this->hasOne(ProfileGenders::className(), ['id' => 'gender']);
    }
}
