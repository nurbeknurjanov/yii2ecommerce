<?php

use yii\db\Migration;
use user\models\User;
use shop\models\Shop;

/**
 * Class m200615_062323_remove_user_id_from_shop_table
 */
class m200615_062323_remove_user_id_from_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('shop_user_id_foreign_key',
            Shop::tableName()
        );
        $this->dropIndex('shop_user_id_index', Shop::tableName());

        $this->dropColumn(Shop::tableName(), 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200615_062323_remove_user_id_from_shop_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200615_062323_add_shop_id_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
