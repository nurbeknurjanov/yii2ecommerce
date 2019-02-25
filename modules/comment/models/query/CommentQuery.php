<?php

namespace comment\models\query;

use comment\models\Comment;
use product\models\Product;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\comment\models\Comment]].
 *
 * @see \comment\models\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/


    public function defaultFrom()
    {
        return $this->from(['comment'=>Comment::tableName()]);
    }

    /**
     * @return $this
     * */
    public function queryClassName($className)
    {
        return $this->andOnCondition(['comment.model_name'=>$className]);
    }
    /**
     * @return $this
     * */
    public function queryModel($model)
    {
        return $this->andOnCondition(['comment.model_id'=>$model->primaryKey]);
    }


    public function queryModelClassName($model)
    {
        $this->queryClassName($model::className());
        return $this->queryModel($model);
    }

    public function ipQuery()
    {
        return $this->andWhere(['ip'=>Yii::$app->request->userIP]);
    }
    public function mine()
    {
        if(Yii::$app->user->id)
            return $this->andWhere(['user_id'=>Yii::$app->user->id]);
        return $this->ipQuery();
    }

    /**
     * @inheritdoc
     * @return \comment\models\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \comment\models\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}