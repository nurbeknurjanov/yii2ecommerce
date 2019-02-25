<?php

use yii\db\Migration;
use product\models\Product;

/**
 * Class m181222_045704_product_network
 */
class m181222_045704_product_network extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_network', [
            'id'=>$this->primaryKey(),
            'product_id'=>$this->integer(),
            'network_type'=>$this->smallInteger(),
            'network_id'=>$this->string(),
            'network_code'=>$this->string(),
        ]);
        $this->dropColumn(Product::tableName(), 'instagram_id');
        $this->dropColumn(Product::tableName(), 'instagram_code');

        $this->createIndex('product_network_index', 'product_network', 'product_id');
        $this->addForeignKey('product_network_product_id', 'product_network', 'product_id',
            Product::tableName(), 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_network');
        $this->addColumn(Product::tableName(), 'instagram_id', $this->string());
        $this->addColumn(Product::tableName(), 'instagram_code', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181222_045704_product_network cannot be reverted.\n";

        return false;
    }
    */
}
