<?php

use yii\db\Migration;
use order\models\Order;


/**
 * Class m200621_162918_add_zip_code_field
 */
class m200621_162918_add_zip_code_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Order::tableName(), 'zip_code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200621_162918_add_zip_code_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200621_162918_add_zip_code_field cannot be reverted.\n";

        return false;
    }
    */
}
