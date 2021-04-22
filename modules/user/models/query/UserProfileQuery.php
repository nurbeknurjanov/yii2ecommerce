<?php

namespace user\models\query;

use user\models\UserProfile;
use Yii;

/**
 * This is the ActiveQuery class for [[\user\models\UserProfile]].
 *
 * @see \user\models\UserProfile
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['userProfile'=>UserProfile::tableName()]);
    }

    /**
     * @inheritdoc
     * @return \user\models\UserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \user\models\UserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}