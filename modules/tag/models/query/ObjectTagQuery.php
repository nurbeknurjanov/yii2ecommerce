<?php

namespace tag\models\query;

/**
 * This is the ActiveQuery class for [[ObjectTag]].
 *
 * @see \tag\models\ObjectTag
 */
class ObjectTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/


    /**
     * @inheritdoc
     * @return \tag\models\ObjectTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \tag\models\ObjectTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}