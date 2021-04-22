<?php

use yii\db\Migration;
use product\models\Product;


/**
 * Handles the creation of table `{{%shop}}`.
 */
class m200509_073800_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'title_url' => $this->string()->notNull(),
            'description' => $this->text(),
            'address' => $this->string(),
        ]);

        $this->insert('{{%shop}}', [
            'user_id'=>1,
            'title'=>'Central Computers',
            'title_url'=>'central-computers',
            'description'=>'We sell computers',
            'address'=>'Aiden street, 40, California, US',
        ]);

        $this->addColumn(Product::tableName(), 'shop_id', $this->integer()->notNull());

        $products = Product::find()->all();
        foreach ($products as $product) {
            $product->updateAttributes(['shop_id' => 1]);
        }

        $this->createIndex('product_shop_id_index', Product::tableName(), 'shop_id');
        $this->addForeignKey('product_shop_id_foreign_key',
            Product::tableName(), 'shop_id',
            '{{%shop}}', 'id', 'RESTRICT','RESTRICT'
        );

        $this->createIndex('shop_user_id_index', '{{%shop}}', 'user_id');
        $this->addForeignKey('shop_user_id_foreign_key',
            '{{%shop}}', 'user_id',
            '{{%user}}', 'id', 'RESTRICT','RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('shop_user_id_foreign_key',
            '{{%shop}}'
        );
        $this->dropIndex('shop_user_id_index', '{{%shop}}');

        $this->dropForeignKey('product_shop_id_foreign_key',
            Product::tableName()
        );
        $this->dropIndex('product_shop_id_index', Product::tableName());

        $this->dropColumn(Product::tableName(), 'shop_id');

        $this->dropTable('{{%shop}}');
    }
}
