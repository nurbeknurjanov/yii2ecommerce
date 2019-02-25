<?php

namespace country\models\query;

/**
 * This is the ActiveQuery class for [[\country\models\Country]].
 *
 * @see \country\models\Country
 */
class CountryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function orderByName()
    {
        return $this->orderBy('name');
    }
    /**
     * @inheritdoc
     * @return \country\models\Country[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \country\models\Country|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}