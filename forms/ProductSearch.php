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
 * @property string $priceRange comma separated min and max values
 * @property-read integer $typeId {@see Product::$type_id}
 */
class ProductSearch extends \yii\base\DynamicModel
{
    use \robote13\catalog\components\KrajeeSliderRange;

    /**
     * @var array {@see \yii\data\Sort::$defaultOrder}
     */
    public $defaultOrder;

    private $dynamicRules = [];

    private $_kind;

    private $_type_id;

    public function __construct(array $attributes = array(), $config = array())
    {
        parent::__construct(array_fill_keys(['id', 'status','slug', 'title', 'vendor_code'],null), $config);
        $this->addRule(['id', 'status'],'integer')
                ->addRule(['slug', 'title', 'productKind', 'vendor_code'], 'string')
                ->addRule(['priceRange'], 'match',['pattern'=>'/^[\d]+\,[\d]+$/']);

        $this->addDynamicAttributes();
    }

    /**
     * Generates an attribute label based on the give attribute name.
     * @param string $name
     * @return string
     */
    public function generateAttributeLabel($name)
    {
        return Yii::t('app', parent::generateAttributeLabel($name));
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
            'type_id' => $this->_type_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'vendor_code', $this->vendor_code])
            ->andFilterWhere(['>=', 'price', $this->_min_price])
            ->andFilterWhere(['<=', 'price', $this->_max_price]);

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
        $this->_type_id = ProductType::find()->select('id')->where(['table'=> str_replace('-','_',$kind)])->scalar();
        if(!$this->_type_id)
        {
            $this->_type_id = null;
        }
        $this->_kind = $kind;
    }

    public function getTypeId()
    {
        return $this->_type_id;
    }

    private function addDynamicAttributes()
    {
        if(!isset($this->_type_id)){
            return false;
        }

        $attributes = TypeCharacteristic::find()->where(['type_id'=> $this->_type_id])->all();
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
        if(!isset($this->_type_id) || empty($this->dynamicRules)){
            return false;
        }

        $conditions = [];
        $query->joinDynamicAttributes($this->_type_id);
        foreach (ArrayHelper::getValue($this->dynamicRules,'integer',[]) as $attrName)
        {
            $conditions[$attrName]= $this->{$attrName};
        }
        $query->andFilterWhere($conditions);
    }
}