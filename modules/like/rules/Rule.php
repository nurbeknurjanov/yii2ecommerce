<?php

namespace like\rules;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use like\models\Like;
use user\models\User;


class Rule extends \yii\rbac\Rule
{
    public $name = 'likeRule';
    

    public function execute($userID, $item, $params)
    {
        $userModel = User::findOne($userID);
        /*if(!$userModel)
            return false;*/

        $roleOrPermission=$item->name;

        switch(true)
        {
            case $roleOrPermission == 'createLike' :
            {
                if(!isset($params['object']))//object is comment
                    throw new Exception("object parameter is missing.");
                $commentObject = $params['object'];
                $likeQuery = Like::find()->defaultFrom()->mine();
                $likeQuery->queryModel($commentObject);
                $likeQuery->queryClassName($commentObject::className());
                return !$likeQuery->exists();
                break;
            }
            case $roleOrPermission == 'deleteLike' || $roleOrPermission == 'updateLike':
            {
                if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
                    return true;

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
