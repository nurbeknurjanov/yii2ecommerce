<?php

namespace user\models\query;
use file\models\File;
use user\models\User;
use yii\db\Expression;
use user\models\Token;

/**
 * This is the ActiveQuery class for [[\user\models\Token]].
 *
 * @see \user\models\Token
 */
class TokenQuery extends \yii\db\ActiveQuery
{

    /**
     * @return $this
     */
    public function last()
    {
        $this->orderBy("created_at DESC");
        return $this;
    }
    public function actionQuery($action)
    {
        return $this->andWhere(['action'=>$action]);
    }
    public function userQuery($user)
    {
        if($user instanceof User)
            $user = $user->id;
        return $this->andWhere(['user_id'=>$user]);
    }

    public function dataQuery($data)
    {
        if($data){
            if(is_array($data))
                $this->andWhere(['data'=>json_encode($data)]);
            else
                $this->andWhere(['data'=>$data]);
        }
        return $this;
    }

    public function runnable()
    {
        $this->andWhere(['OR', ['run'=>0], ['reusable'=>1]]);
        return $this->notExpired();
    }

    public function notExpired()
    {
        return $this->andWhere(['OR', ['>=','expire_date', date('Y-m-d H:i:s')], ['expire_date'=>null]]);
    }


    /**
     * @inheritdoc
     * @return \user\models\Token[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \user\models\Token|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}