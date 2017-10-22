<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%product_type}}".
 *
 * @property int $id
 * @property string $title
 * @property string $table
 *
 * @property-read string $kind Description
 * @property-read string $dynamicTableName
 * @property Product[] $catalogProducts
 * @property TypeCharacteristic[] $typeCharacteristics
 */
class ProductType extends \yii\db\ActiveRecord
{

    use \robote13\yii2components\traits\DropdownItemsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_type}}';
    }

    public function init()
    {
        $this->attachInvalidate();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','table'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['table','match','pattern'=>'/^[a-z]{1}[a-z\_]{1,}[a-z]{1}$/']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'title' => Yii::t('robote13/catalog', 'Title'),
            'table' => Yii::t('robote13/catalog', 'Table'),
        ];
    }

    public function getKind()
    {
        return str_replace('_','-', $this->table);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProducts()
    {
        return $this->hasMany(Product::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeCharacteristics()
    {
        return $this->hasMany(TypeCharacteristic::className(), ['type_id' => 'id']);
    }

    public function getDynamicTableName()
    {
        return "{{%p_{$this->table}}}";
    }
}
