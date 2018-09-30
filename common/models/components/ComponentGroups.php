<?php

namespace common\models\components;

use Yii;

/**
 * This is the model class for table "component_groups".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $sort
 * @property string $description
 *
 * @property ComponentList[] $componentLists
 */
class ComponentGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'component_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 256],
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
            'sort' => 'Sort',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentLists()
    {
        return $this->hasMany(ComponentList::className(), ['group_id' => 'id']);
    }
}
