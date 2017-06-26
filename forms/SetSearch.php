<?php

namespace robote13\catalog\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\Set;

/**
 * SetSearch represents the model behind the search form of `robote13\catalog\models\Set`.
 */
class SetSearch extends Set
{
    public $defaultOrder;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['slug_index', 'slug', 'title', 'description', 'updated_in'], 'safe'],
            [['discount_amount'], 'number'],
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
        $query = Set::find();

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

        $dataProvider->getSort()->defaultOrder = $this->defaultOrder;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'discount_amount' => $this->discount_amount,
            'updated_in' => $this->updated_in,
        ]);

        $query->andFilterWhere(['like', 'slug_index', $this->slug_index])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
