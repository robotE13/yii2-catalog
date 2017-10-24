<?php

namespace robote13\catalog\forms;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\Product;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\TypeCharacteristic;

/**
 * ProductSearch represents the model behind the search form of `robote13\catalog\models\Product`.
 *
 * @property integer $id
 * @property string $title
 * @property string $slug friendly URL
 * @property integer $status
 * @property string $productKind
 */
class ProductSearch extends \yii\base\DynamicModel
{
    /**
     * @var array {@see \yii\data\Sort::$defaultOrder}
     */
    public $defaultOrder;

    private $dynamicRules = [];

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

        $this->addDynamicConditions($query);

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
        if(!isset($this->type_id)){
            return false;
        }

        $attributes = TypeCharacteristic::find()->where(['type_id'=> $this->type_id])->all();
        foreach ($attributes as $attribute)
        {
            $this->defineAttribute($attribute->attribute);
            $this->dynamicRules[$attribute->validator][]=$attribute->attribute;
        }

        ArrayHelper::remove($rules,'unknown');

        foreach ($this->dynamicRules as $rule => $attrNames)
        {
            $this->addRule($attrNames, $rule);
        }
    }

    /**
     *
     * @param \robote13\catalog\models\ProductQuery $query Description
     */
    private function addDynamicConditions(&$query)
    {
        if(!isset($this->type_id)){
            return false;
        }

        $conditions = [];
        $query->joinDynamicAttributes($this->type_id);
        foreach (ArrayHelper::getValue($this->dynamicRules,'integer',[]) as $attrName)
        {
            $conditions[$attrName]= $this->{$attrName};
        }
        $query->andFilterWhere($conditions);
    }
}