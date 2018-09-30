<?php

namespace common\models\main;

use Yii;

/**
 * This is the model class for table "main_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $value
 */
class MainSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'string', 'max' => 32],
            [['value'], 'string', 'max' => 64],
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
            'value' => 'Значение',
        ];
    }

    /*
     *
     */
    public function getSystemCode() {
        return [
            'SiteName',
            'AdminEmail',
            'templateName',
        ];
    }
}
