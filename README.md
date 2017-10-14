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

### Подключение модуля:

```php
'modules' => [
    'backend'=>[
        'modules'=>[
            'shop-catalog' => [
                'class' => 'robote13\catalog\Module',
                'controllerNamespace' => 'robote13\catalog\backend\controllers',
            ],
        ]
    ],
    'shop-catalog' => [
        'class' => 'robote13\catalog\Module'
    ],
],
```
### Настройка хранилища для badge

Все операции по работе с хранилищем производятся при помощи абстрактной файловой системы [Flysystem](http://flysystem.thephpleague.com/).
Для модуля по умолчанию установлено имя компонента файловой системы: `catalogPreviews` (см. `robote13\catalog\Module::previewUploaderOptions`)


```php
'components' => [
    'catalogPreviews'=>function(){
        $adapter = new League\Flysystem\Adapter\Local(Yii::getAlias('@app/web/catalog-previews'));
        return new \League\Flysystem\Filesystem($adapter);
    }
]
```