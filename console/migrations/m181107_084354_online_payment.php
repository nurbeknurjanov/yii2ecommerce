<?php

use yii\db\Migration;
use order\models\Order;

/**
 * Class m181107_084354_online_payment
 */
class m181107_084354_online_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Order::tableName(), 'online_payment_type', $this->smallInteger()->null());
        $this->addColumn(Order::tableName(), 'online_payment_status', $this->smallInteger()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Order::tableName(), 'online_payment_type');
        $this->dropColumn(Order::tableName(), 'online_payment_status');
    }
}
