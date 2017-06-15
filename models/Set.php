<?php

namespace robote13\catalog\models;

use Yii;
use robote13\yii2components\behaviors\IndexedStringBehavior;
use voskobovich\linker\LinkerBehavior;
use voskobovich\linker\updaters\ManyToManySmartUpdater;

/**
 * This is the model class for table "{{%catalog_set}}".
 *
 * @property int $id
 * @property string $slug_index
 * @property string $slug
 * @property string $title
 * @property string $badge
 * @property integer $status
 * @property string $description
 * @property string $discount_amount
 *
 * @property SetProduct[] $setProducts
 * @property CatalogProduct[] $products
 */
class Set extends \yii\db\ActiveRecord
{
    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_set}}';
    }

    public function behaviors()
    {
        return [
            'indexed'=>[
                'class'=> IndexedStringBehavior::className(),
                'attribute' => 'slug',
                'indexAttribute' => 'slug_index'
            ],
            'statusText'=>[
                'class'=> \robote13\yii2components\behaviors\TextStatusBehavior::className(),
                'attributes'=>[
                    'status'=> self::getStatuses()
                ]
            ],
            'uploadBehavior' => [
                'class' => 'vova07\fileapi\behaviors\UploadBehavior',
                'attributes' => [
                    'badge' => [
                        'url' => Yii::getAlias('@web/previews/')
                    ]
                ]
            ],
            'relationalSave'=>[
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'productsIds'=>[
                        'products',
                        'updater'=>[
                            'class' => ManyToManySmartUpdater::className()
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'description', 'discount_amount'], 'required'],
            ['productsIds','each','rule'=>['integer']],
            ['status','in','range'=> array_keys(self::getStatuses())],
            [['description'], 'string'],
            [['discount_amount'], 'number'],
            [['slug', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'slug_index' => Yii::t('robote13/catalog', 'Slug Index'),
            'slug' => Yii::t('robote13/catalog', 'Slug'),
            'title' => Yii::t('robote13/catalog', 'Title'),
            'status' => Yii::t('robote13/catalog', 'Status'),
            'description' => Yii::t('robote13/catalog', 'Description'),
            'discount_amount' => Yii::t('robote13/catalog', 'Discount Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetProducts()
    {
        return $this->hasMany(SetProduct::className(), ['set_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('{{%set_product}}', ['set_id' => 'id']);
    }

    public function getPrice()
    {
        $price = 0;
        foreach($this->products as $product)
        {
            $price += $product->price;
        }
        return $price;
    }

    public function getIsAvailable()
    {
        return $this->status == static::STATUS_ENABLED;
    }

    public static function getStatuses()
    {
        return [
            static::STATUS_ENABLED => \Yii::t('robote13/catalog','Enabled'),
            static::STATUS_DISABLED => \Yii::t('robote13/catalog','Disabled'),
        ];
    }

    /**
     * @inheritdoc
     * @return SetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetQuery(get_called_class());
    }
}
