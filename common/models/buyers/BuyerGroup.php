<?php

namespace common\models\buyers;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "buyer_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $sort
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BuyerAssign[] $buyerAssigns
 * @property Price[] $prices
 * @property Price[] $prices0
 */
class BuyerGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buyer_group';
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
            [['sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
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
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyerAssigns()
    {
        return $this->hasMany(BuyerAssign::className(), ['buyer_group' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['show_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices0()
    {
        return $this->hasMany(Price::className(), ['buy_group_id' => 'id']);
    }
}
