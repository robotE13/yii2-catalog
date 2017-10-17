<?php

use yii\db\Migration;

class m170501_190121_add_popularity_column extends Migration
{
    public $table = "{{%catalog_product}}";

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->addColumn($this->table, 'popularity', $this->integer()->notNull()->after('status')->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'popularity');
    }
}
