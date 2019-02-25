<?php

namespace country\models\query;

use country\models\City;
use Yii;

/**
 * This is the ActiveQuery class for [[\country\models\City]].
 *
 * @see \country\models\City
 */
class CityQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['city'=>City::tableName()]);
    }

    public function orderByName()
    {
        return $this->addOrderBy('name');
    }


    public function regionQuery($region_id)
    {
        $this->andWhere(['region_id'=>$region_id]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \country\models\City[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \country\models\City|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}