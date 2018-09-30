<?php

namespace common\models\components;

use Yii;

/**
 * This is the model class for table "component_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $sort
 * @property integer $group_id
 * @property string $description
 * @property string $params
 *
 * @property ComponentApply[] $componentApplies
 * @property ComponentGroups $group
 */
class ComponentList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'component_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'group_id'], 'integer'],
            [['params'], 'string'],
            [['name', 'code'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 256],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentGroups::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'sort' => 'Сортировка',
            'group_id' => 'Группа',
            'description' => 'Описание',
            'params' => 'Параметры',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentApplies()
    {
        return $this->hasMany(ComponentApply::className(), ['component_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ComponentGroups::className(), ['id' => 'group_id']);
    }

    public function makeParamsArray() {
        $this->params = unserialize($this->params);
    }
    
    static function createParamsString($params) {
        $keys = array_keys($params);
        $result = [];
        foreach($params[$keys[0]] as $k=>$val) {
            if($val == '') continue;
            $result[$val] = $params[$keys[1]][$k];
        }

        return serialize($result);
    }
}
