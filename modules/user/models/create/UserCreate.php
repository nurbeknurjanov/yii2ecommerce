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
    protected static function prepareUser($attributes, $profileAttributes=[])
    {
        if(!isset($attributes['email']) && !$attributes['email'])
            throw new Exception("Email attribute is missing.");

        if(User::find()->defaultFrom()->emailQuery($attributes['email'])->exists())
            throw new Exception("User already exists.");

        $user = new User($attributes);
        $userProfile = $user->userProfileObject;
        $userProfile->attributes = $profileAttributes;

        if(isset($attributes['password']) && $attributes['password']){
            $user->setPassword($attributes['password']);
            $user->generateAuthKey();
        }

        return [$user, $userProfile];
    }
    public static function create($attributes=[], $profileAttributes, $validation=true)
    {
        $return = self::prepareUser($attributes, $profileAttributes);
        $user = $return[0];
        $userProfile = $return[1];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user->validate();
            if(!$user->save($validation))
                throw new Exception(Html::errorSummary($user));
            if($profileAttributes){
                $userProfile->id = $user->id;
                if(!$userProfile->save($validation))
                    throw new Exception(Html::errorSummary($userProfile));
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
        }
        return $user;
    }

    //for sign up
    public static function createUserInactive($attributes=[], $profileAttributes = [])
    {
        $attributes['rolesAttribute'] = [User::ROLE_USER, User::ROLE_MANAGER];
        $attributes['status'] = User::STATUS_INACTIVE;
        return self::create($attributes,$profileAttributes);
    }
    //for social network, for order user, for invite //TODO
    public static function createUserInactiveForce($attributes=[],$profileAttributes = [])
    {
        $attributes['rolesAttribute'] = [User::ROLE_USER, User::ROLE_MANAGER];
        $attributes['status'] = User::STATUS_INACTIVE;
        return self::create($attributes, $profileAttributes, false);
    }

}


