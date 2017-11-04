<?php

use yii\db\Migration;

class m171104_165112_add_short_description extends Migration
{
    public $table = "{{%catalog_product}}";

    public function up()
    {
        $this->addColumn($this->table, 'short_description', $this->string()->notNull()->defaultValue('')->after('badge'));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'short_description');
    }
}
