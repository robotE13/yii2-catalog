<?php

use yii\db\Migration;

class m170616_155415_add_popularity_to_set extends Migration
{
    public $table = "{{%catalog_set}}";

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->addColumn($this->table, 'popularity', $this->integer()->notNull()->defaultValue(0)->after('status'));
    }

    public function down()
    {
        $this->dropColumn($this->table,'popularity');
    }
}
