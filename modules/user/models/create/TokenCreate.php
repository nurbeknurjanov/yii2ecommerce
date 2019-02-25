<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace user\models\create;


use user\models\query\TokenQuery;
use user\models\Token;
use Yii;
use order\models\Order;
use user\models\User;

class TokenCreate extends Token
{

    public static function create($action, $user=null, $data=null)
    {
        $token = new Token();
        $token->action = $action;
        if(is_numeric($user))
            $token->user_id = $user;
        if($user instanceof User)
            $token->user_id = $user->id;
        $token->data = $data;
        $token->save();
        return $token;
    }

    public static function createIfNotExists($action, $user, $data=null)
    {
        /* @var $query TokenQuery */
        $query = self::find()->userQuery($user)->runnable()->dataQuery($data)->last();
        if($token = $query->one()){
            $token->updateExpiredDate();
            return $token;
        }
        return self::create($action, $user, $data);
    }
    public static function createNewRefresh($action, $user, $data=null)
    {
        /* @var $query TokenQuery */
        $query = self::find()->actionQuery($action)->userQuery($user)->dataQuery($data);
        Token::deleteAll($query->where);
        return self::create($action, $user, $data);
    }



    public static function createForPasswordReset($user)
    {
        $token = static::create(self::ACTION_RESET_PASSWORD, $user);
        $token->updateAttributes(['expire_date'=>date('Y-m-d H:i:s', time() + Yii::$app->params['user.passwordResetTokenExpire']),]);
        return $token;
    }


}