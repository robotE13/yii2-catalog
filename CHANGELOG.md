0.3.2
-----

Dynamic attributes for the ProductSearch model has been added.

Removed:
```
robote13\catalog\models\ProductQuery::typeAlias()
robote13\catalog\backend\controllers\MainController
```

Rename/move:
```
robote13\catalog\Module::$defaultRoute 'main' -> 'product'
robote13\catalog\frontend\controllers\MainController -> ProductController
robote13\catalog\forms\ProductSearch::$kind -> $productKind
```

0.3.0
-----

Since the organization of the tree structure of the "Categories" pages does not applicable to the catalog directly,
categories support has been removed.
 
Removed:
```
robote13\catalog\backend\controllers\CategoryController
robote13\catalog\models\Category
robote13\catalog\models\CategoryProduct
robote13\catalog\models\CategoryQuery
robote13\catalog\Module::enableCategories
robote13\catalog\models\Product::getCategories()
robote13\catalog\models\Product::getCategoryProducts()
```

If you used the binding of goods to categories, then you need to create a separate category module and generate
models, controllers etc.

If you have not used "categories" for products, you can create a migration to remove unused tables:

```php
<?php

use yii\db\Migration;

class mxxxxxx_xxxxxx_remove_unused extends Migration
{
    public function up()
    {
        $this->dropTable("{{%category_product}}");
        $this->dropTable("{{%catalog_category}}");
    }
}
```
