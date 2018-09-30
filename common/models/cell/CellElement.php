<?php

namespace common\models\cell;

use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cell_element".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $active
 * @property integer $sort
 * @property integer $cell_type_id
 * @property integer $cell_id
 * @property integer $section_id
 * @property integer $user_id
 * @property integer $preview_picture
 * @property string $preview_text
 * @property integer $detail_picture
 * @property string $detail_text
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CellType $cellType
 * @property CellItem $cell
 * @property CellSection $section
 * @property User $user
 * @property CellImages $previewPicture
 * @property CellImages $detailPicture
 * @property CellSeo[] $cellSeos
 */
class CellElement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_element';
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
            [['active', 'sort', 'cell_type_id', 'cell_id', 'section_id', 'user_id', 'preview_picture', 'detail_picture', 'created_at', 'updated_at'], 'integer'],
            [['preview_text', 'detail_text'], 'string'],
            [['name', 'code'], 'string', 'max' => 32],
            [['cell_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellType::className(), 'targetAttribute' => ['cell_type_id' => 'id']],
            [['cell_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellItem::className(), 'targetAttribute' => ['cell_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellSection::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['preview_picture'], 'exist', 'skipOnError' => true, 'targetClass' => CellImages::className(), 'targetAttribute' => ['preview_picture' => 'id']],
            [['detail_picture'], 'exist', 'skipOnError' => true, 'targetClass' => CellImages::className(), 'targetAttribute' => ['detail_picture' => 'id']],
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
            'cell_type_id' => 'Cell Type ID',
            'cell_id' => 'Cell ID',
            'section_id' => 'Section ID',
            'user_id' => 'User ID',
            'preview_picture' => 'Картинка анонса',
            'preview_text' => 'Описание анонса',
            'detail_picture' => 'Детальная картинка',
            'detail_text' => 'Детальное описание',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getSection()
    {
        return $this->hasOne(CellSection::className(), ['id' => 'section_id']);
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
    public function getDetailPicture()
    {
        return $this->hasOne(CellImages::className(), ['id' => 'detail_picture']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellSeos()
    {
        return $this->hasMany(CellSeo::className(), ['element_id' => 'id']);
    }
}
