<?php

namespace common\models\cell;

use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cell_section".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $depth
 * @property integer $parent
 * @property integer $cell_type_id
 * @property integer $cell_id
 * @property integer $preview_picture
 * @property string $preview_text
 * @property integer $active
 * @property integer $sort
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CellElement[] $cellElements
 * @property CellType $cellType
 * @property CellItem $cell
 * @property User $user
 * @property CellImages $previewPicture
 * @property CellSeo[] $cellSeos
 */
class CellSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_section';
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
            [['depth', 'parent', 'cell_type_id', 'cell_id', 'preview_picture', 'active', 'sort', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['preview_text'], 'string'],
            [['name', 'code'], 'string', 'max' => 32],
            [['cell_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellType::className(), 'targetAttribute' => ['cell_type_id' => 'id']],
            [['cell_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellItem::className(), 'targetAttribute' => ['cell_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['preview_picture'], 'exist', 'skipOnError' => true, 'targetClass' => CellImages::className(), 'targetAttribute' => ['preview_picture' => 'id']],
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
            'depth' => 'Depth',
            'parent' => 'Parent',
            'cell_type_id' => 'Cell Type ID',
            'cell_id' => 'Cell ID',
            'preview_picture' => 'Картинка раздела',
            'preview_text' => 'Текст анонса',
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellElements()
    {
        return $this->hasMany(CellElement::className(), ['section_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellType()
    {
        return $this->hasOne(CellType::className(), ['id' => 'cell_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCell()
    {
        return $this->hasOne(CellItem::className(), ['id' => 'cell_id']);
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
    public function getPreviewPicture()
    {
        return $this->hasOne(CellImages::className(), ['id' => 'preview_picture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellSeos()
    {
        return $this->hasMany(CellSeo::className(), ['section_id' => 'id']);
    }
}
