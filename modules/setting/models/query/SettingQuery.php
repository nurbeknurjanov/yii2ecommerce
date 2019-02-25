<?php

namespace setting\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\setting\models\Setting]].
 *
 * @see \setting\models\Setting
 */
class SettingQuery extends \yii\db\ActiveQuery
{
    public function key($key)
    {
        return $this->andWhere(['key'=>$key]);
    }

    /**
     * @inheritdoc
     * @return \setting\models\Setting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \setting\models\Setting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}