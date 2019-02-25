<?php

namespace coupon\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\coupon\models\Coupon]].
 *
 * @see \coupon\models\Coupon
 */
class CouponQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $today = date('Y-m-d');
        $this->andWhere(['AND', "interval_from<=STR_TO_DATE('$today', '%Y-%m-%d')", "interval_to>=STR_TO_DATE('$today', '%Y-%m-%d')"]);
        $this->andWhere(['OR', ['used'=>0], ['reusable'=>1]]);
        return $this;
    }

    public function codeQuery($code)
    {
        return $this->andWhere(['=', 'code', $code]);
    }

    /**
     * @inheritdoc
     * @return \coupon\models\Coupon[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \coupon\models\Coupon|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}