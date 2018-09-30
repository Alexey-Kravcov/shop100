<?php

namespace common\models\cell;

use Yii;
use common\models\users\User;

/**
 * This is the model class for table "cell_images".
 *
 * @property integer $id
 * @property string $path
 * @property string $name
 * @property string $extension
 * @property integer $filesize
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property CellElement[] $cellElements
 * @property CellElement[] $cellElements0
 * @property User $user
 * @property CellSection[] $cellSections
 */
class CellImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filesize', 'user_id', 'created_at'], 'integer'],
            [['path'], 'string', 'max' => 128],
            [['name'], 'string', 'max' => 32],
            [['extension'], 'string', 'max' => 6],
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
            'filesize' => 'Filesize',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellElements()
    {
        return $this->hasMany(CellElement::className(), ['preview_picture' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellElements0()
    {
        return $this->hasMany(CellElement::className(), ['detail_picture' => 'id']);
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
    public function getCellSections()
    {
        return $this->hasMany(CellSection::className(), ['preview_picture' => 'id']);
    }
}
