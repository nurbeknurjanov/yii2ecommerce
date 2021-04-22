<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace comment\rules;

use comment\models\Comment;
use Yii;
use yii\base\Exception;
use user\models\User;


class Rule extends \yii\rbac\Rule
{
    public $name = 'commentRule';
    public function execute($userID, $item, $params)
    {
        if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            return true;

        $userModel = User::findOne($userID);
        /*if(!$userModel)
            return false;*/

        $roleOrPermission=$item->name;
        switch(true){
            case $roleOrPermission == 'createComment':{
                if(!isset($params['object']))//object is product
                    throw new Exception("object parameter is missing.");
                $productObject = $params['object'];
                $commentQuery = Comment::find()->defaultFrom()->mine();
                $commentQuery->queryModel($productObject);
                $commentQuery->queryClassName($productObject::className());
                return !$commentQuery->exists();
                break;
            }
            case $roleOrPermission == 'deleteComment' || $roleOrPermission == 'updateComment':{
                if(!isset($params['model']))
                    throw new Exception("model parameter is missing.");
                if($userModel)
                    return $params['model']->user_id==$userModel->id;
                else
                    return $params['model']->ip==Yii::$app->request->userIP;
                break;
            }
        }
        return false;
    }
}

