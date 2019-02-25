<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models\query;

use order\models\Order;
use order\models\OrderLocal;
use user\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\order\models\Order]].
 *
 * @see \order\models\Order
 */
class OrderQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        $this->from(['order'=>Order::tableName()]);
        return $this;
    }

    public function queryUser(User $user)
    {
        $this->andWhere(['order.user_id'=>$user->id]);
    }
    public function queryEmail($email)
    {
        return $this->andWhere(['email'=>$email]);
    }
    public function mine()
    {
        if (Yii::$app->user->id)
            return $this->andWhere(['order.user_id'=>Yii::$app->user->id]);

        return $this->andWhere(['AND',
            //['order.user_id'=>null],
            ['order.ip'=>Yii::$app->request->userIP],
            ['order.id'=>ArrayHelper::map(OrderLocal::findAll(), 'id', 'id')],
            ]);
    }

    public function newStatus()
    {
        return $this->andWhere(['status'=>Order::STATUS_NEW]);
    }
    public function defaultOrder()
    {
        return $this->orderBy('created_at');
    }
    /**
     * @inheritdoc
     * @return \order\models\Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \order\models\Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}