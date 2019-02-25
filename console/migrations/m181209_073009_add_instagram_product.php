<?php

use yii\db\Migration;
use product\models\Product;

/**
 * Class m181209_073009_add_instagram_product
 */
class m181209_073009_add_instagram_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Product::tableName(), 'instagram_id', $this->string());
        $this->addColumn(Product::tableName(), 'instagram_code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Product::tableName(), 'instagram_id');
        $this->dropColumn(Product::tableName(), 'instagram_code');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_073009_add_instagram_product cannot be reverted.\n";

        return false;
    }
    */
}
