<?php

namespace country\models\query;

use country\models\Region;
use Yii;

/**
 * This is the ActiveQuery class for [[\country\models\Region]].
 *
 * @see \country\models\Region
 */
class RegionQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['region'=>Region::tableName()]);
    }

    public function orderByName()
    {
        return $this->orderBy('name');
    }

    public function countryQuery($country_id)
    {
        $this->andWhere(['country_id'=>$country_id]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \country\models\Region[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \country\models\Region|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}