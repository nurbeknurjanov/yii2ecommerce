<?php

namespace console\models;

use Yii;

/**
 * This is the ActiveQuery class for [[Upwork]].
 *
 * @see Upwork
 */
class UpworkQuery extends \yii\db\ActiveQuery
{
    /*public function defaultFrom()
    {
        return $this->from([''=>]);
    }*/

    public function findTitleAndDate($title, $date)
    {
        return $this->andWhere(['date'=>$date, 'title'=>$title]);
    }
    /**
     * @inheritdoc
     * @return Upwork[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Upwork|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}