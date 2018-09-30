<?php

namespace common\models\cell;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cell\CellProperty;

/**
 * CellPropertySearch represents the model behind the search form about `common\models\cell\CellProperty`.
 */
class CellPropertySearch extends CellProperty
{

    private $type;
    public $cellID;

    public function __construct($type, $cellID) {
        parent::__construct();
        $this->type = $type;
        $this->cellID = $cellID;
    }

        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'sort', 'multiple', 'filtrable', 'required', 'description'], 'integer'],
            [['name', 'code', 'default_value', 'property_type', 'own'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CellProperty::find()
            ->where(['own'=>$this->type, 'cell_id'=>$this->cellID]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'sort' => $this->sort,
            'multiple' => $this->multiple,
            'filtrable' => $this->filtrable,
            'required' => $this->required,
            'description' => $this->description,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'default_value', $this->default_value])
            ->andFilterWhere(['like', 'property_type', $this->property_type])
            ->andFilterWhere(['like', 'own', $this->own]);

        return $dataProvider;
    }
}
