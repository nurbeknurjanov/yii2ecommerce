<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace user\models\create;

use user\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\Html;

class UserCreate extends \user\models\User
{
    protected static function prepareUser($attributes)
    {
        if(!isset($attributes['email']) && !$attributes['email'])
            throw new Exception("Email attribute is missing.");

        if(User::find()->defaultFrom()->emailQuery($attributes['email'])->exists())
            throw new Exception("User already exists.");

        $user = new User($attributes);

        if(isset($attributes['password']) && $attributes['password']){
            $user->setPassword($attributes['password']);
            $user->generateAuthKey();
        }

        if(Yii::$app->session->get('referrer_id'))
            $user->referrer_id = Yii::$app->session->get('referrer_id');
        $from = Yii::$app->response->cookies->get('from')?:Yii::$app->request->cookies->get('from');
        if($from){
            $user->from = $from;
            if($referrer = User::findOne(['email'=>$user->from,]))
                $user->referrer_id = $referrer->id;
            Yii::$app->response->cookies->remove('from');
        }
        return $user;
    }
    public static function create($attributes=[])
    {
        $user = self::prepareUser($attributes);
        if($user->save())
            return $user;
        else
            throw new Exception(Html::errorSummary($user));
    }

    //for sign up
    public static function createUserInactive($attributes=[])
    {
        $attributes['rolesAttribute'] = User::ROLE_USER;
        $attributes['status'] = User::STATUS_INACTIVE;
        return self::create($attributes);
    }
    //for social network, for order user, for invite //TODO
    public static function createUserInactiveForce($attributes=[])
    {
        $attributes['rolesAttribute'] = User::ROLE_USER;
        $attributes['status'] = User::STATUS_INACTIVE;
        $user = self::prepareUser($attributes);
        if($user->save(false))
            return $user;
        else
            throw new Exception(Html::errorSummary($user));
    }

}