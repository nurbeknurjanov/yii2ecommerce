<?php

namespace like\models\query;

use like\models\Like;
use Yii;

/**
 * This is the ActiveQuery class for [[\like\models\Like]].
 *
 * @see \like\models\Like
 */
class LikeQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['like'=>Like::tableName()]);
    }
    public function modelQuery($model, $className=null)
    {
        if(!$className)
            $className=$model::className();
        return $this->andWhere(['like.model_name'=>$className, 'like.model_id'=>$model->id]);
    }

    /**
     * @return $this
     * */
    public function queryClassName($className)
    {
        return $this->andOnCondition(['like.model_name'=>$className]);
    }
    /**
     * @return $this
     * */
    public function queryModel($model)
    {
        return $this->andOnCondition(['like.model_id'=>$model->primaryKey]);
    }

    public function queryModelClassName($model)
    {
        $this->queryClassName($model::className());
        return $this->queryModel($model);
    }


    public function ipQuery()
    {
        return $this->andWhere(['like.ip'=>Yii::$app->request->userIP]);
    }
    public function mine()
    {
        if(Yii::$app->user->id)
            return $this->andWhere(['like.user_id'=>Yii::$app->user->id]);
        return $this->ipQuery();
    }

    /**
     * @inheritdoc
     * @return \like\models\Like[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \like\models\Like|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}