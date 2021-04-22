<?php

use yii\db\Migration;
use user\models\User;
use shop\models\Shop;


/**
 * Handles the creation of table `{{%user_shop}}`.
 */
class m200615_065023_create_user_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_shop}}', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'shop_id'=>$this->integer()->notNull(),
            'position'=>$this->string()->notNull(),
        ]);

        $this->createIndex('user_shop_user_id_index', '{{%user_shop}}', 'user_id');
        $this->addForeignKey('user_shop_user_id_key',
            '{{%user_shop}}', 'user_id',
            '{{%user}}', 'id', 'RESTRICT','RESTRICT'
        );

        $this->createIndex('user_shop_shop_id_index', '{{%user_shop}}', 'shop_id');
        $this->addForeignKey('user_shop_shop_id_key',
            '{{%user_shop}}', 'shop_id',
            '{{%shop}}', 'id', 'RESTRICT','RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_shop}}');
    }
}
