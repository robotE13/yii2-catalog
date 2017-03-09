Product catalog. Yii2 module
============================
Catalog of products for online store. Prices, sets, leftovers in the warehouse. 
In the module, the "Class Table Inheritance" design pattern is used to represent the different categories of products.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist robote13/yii2-catalog "*"
```

or add

```
"robote13/yii2-catalog": "*"
```

to the require section of your `composer.json` file.


Usage
-----

```php
'modules' => [
    'backend'=>[
        'modules'=>[
            'shop-catalog' => [
                'class' => 'robote13\catalog\Module',
                'controllerNamespace' => 'robote13\catalog\frontend\controllers',
            ],
        ]
    ],
    'shop-catalog' => [
        'class' => 'robote13\catalog\Module',//
    ],
],
```