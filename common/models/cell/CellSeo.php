<?php

namespace common\models\cell;

use Yii;

/**
 * This is the model class for table "cell_seo".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $element_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * @property CellSection $section
 * @property CellElement $element
 */
class CellSeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'element_id'], 'integer'],
            [['meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 256],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellSection::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['element_id'], 'exist', 'skipOnError' => true, 'targetClass' => CellElement::className(), 'targetAttribute' => ['element_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Section ID',
            'element_id' => 'Element ID',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
        ];
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
    public function getElement()
    {
        return $this->hasOne(CellElement::className(), ['id' => 'element_id']);
    }

    /*
     *
     */
    public function savePost($seoModel, $modelID, $type) {
        if($seoModel->load(Yii::$app->request->post()) ) {
            if($seoModel->meta_title == '' && $seoModel->meta_keywords == '' && $seoModel->meta_description == '') {
                $seoModel->delete();
                return false;
            }
            if($type == 'element') $seoModel->element_id = $modelID;
                elseif($type == 'section') $seoModel->section_id = $modelID;
            return $seoModel->save();
        }
    }
}
