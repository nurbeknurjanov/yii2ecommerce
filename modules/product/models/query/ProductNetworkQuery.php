<?php

namespace product\models\query;

use product\models\ProductNetwork;
use Yii;

/**
 * This is the ActiveQuery class for [[\product\models\ProductNetwork]].
 *
 * @see \product\models\ProductNetwork
 */
class ProductNetworkQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['product_network'=>ProductNetwork::tableName()]);
    }
    public function instagram()
    {
        $this->defaultFrom();
        return $this->andOnCondition(['product_network.network_type'=>ProductNetwork::NETWORK_TYPE_INSTAGRAM]);
    }

    /**
     * @inheritdoc
     * @return \product\models\ProductNetwork[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \product\models\ProductNetwork|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}