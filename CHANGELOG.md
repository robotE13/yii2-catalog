754a3954ac39874d1b6b00cae089b482f0b0c670
------
default route = 'product'
renamed frontend/controllers/MainController -> frontend/controllers/ProductController
removed backend/controllers/MainController

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