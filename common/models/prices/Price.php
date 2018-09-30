<?php

namespace common\models\prices;

use Yii;
use common\models\buyers\BuyerGroup;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $sort
 * @property integer $base
 * @property integer $ratio
 * @property integer $show_group_id
 * @property integer $buy_group_id
 *
 * @property BuyerGroup $showGroup
 * @property BuyerGroup $buyGroup
 * @property PriceAssign[] $priceAssigns
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'base', 'show_group_id', 'buy_group_id'], 'integer'],
            [['ratio'], 'safe'],
            [['name', 'code'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            [['show_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuyerGroup::className(), 'targetAttribute' => ['show_group_id' => 'id']],
            [['buy_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuyerGroup::className(), 'targetAttribute' => ['buy_group_id' => 'id']],
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
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'base' => 'Основная цена',
            'ratio' => 'Отношение цены к основной цене',
            'show_group_id' => 'Показыть цену группе',
            'buy_group_id' => 'Покупать по этой цене могут',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowGroup()
    {
        return $this->hasOne(BuyerGroup::className(), ['id' => 'show_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyGroup()
    {
        return $this->hasOne(BuyerGroup::className(), ['id' => 'buy_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceAssigns()
    {
        return $this->hasMany(PriceAssign::className(), ['price_id' => 'id']);
    }
}
