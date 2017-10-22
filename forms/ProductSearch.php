<?php

namespace robote13\catalog\forms;

use Yii;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\Product;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\TypeCharacteristic;

/**
 * ProductSearch represents the model behind the search form of `robote13\catalog\models\Product`.
 *
 * @property string $productKind
 */
class ProductSearch extends \yii\base\DynamicModel
{
    public $defaultOrder;

    private $_kind;

    private $type_id;

    public function __construct(array $attributes = array(), $config = array())
    {
        parent::__construct(array_fill_keys(['id', 'status','slug', 'title', 'vendor_code','price'],null), $config);
        $this->addRule(['id', 'status'],'integer')
                ->addRule(['slug', 'title', 'productKind', 'vendor_code'], 'string')
                ->addRule(['price'], 'number');

        $this->addDynamicAttributes();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        $class = Yii::$container->get(Product::className())->className();
        $query = $class::find();

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

        $dataProvider->getSort()->attributes['popularity']=[
            'asc'=>['popularity'=>SORT_ASC],
            'desc'=>['popularity'=>SORT_DESC],
            'default'=>SORT_DESC
        ];
        $dataProvider->getSort()->attributes['productKind']=[
            'asc'=>['type.title'=>SORT_ASC],
            'desc'=>['type.title'=>SORT_DESC],
            'default'=>SORT_DESC
        ];

        $dataProvider->getSort()->defaultOrder = $this->defaultOrder;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'vendor_code', $this->vendor_code]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }

    public function getProductKind()
    {
        return $this->_kind;
    }

    public function setProductKind($kind)
    {
        $this->type_id = ProductType::find()->select('id')->where(['table'=> str_replace('-','_',$kind)])->scalar();
        if(!$this->type_id)
        {
            $this->type_id = null;
        }
        $this->_kind = $kind;
    }

    private function addDynamicAttributes()
    {
        if(!isset($this->type_id))
            return false;

        $rules = [];
        $attributes = TypeCharacteristic::find()->where(['type_id'=> $this->type_id])->all();
        foreach ($attributes as $attribute)
        {
            $this->defineAttribute($attribute->attribute);
            $rules[$attribute->validator][]=$attribute->attribute;
        }
        foreach ($rules as $rule => $attrNames)
        {
            $this->addRule($attrNames, $rule);
        }
    }

}