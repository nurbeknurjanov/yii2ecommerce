<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\query;
use file\models\File;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\file\models\File]].
 *
 * @see \file\models\File
 */
class FileQuery extends \yii\db\ActiveQuery
{

    /**
     * @return $this
     * */
    public function defaultFrom()
    {
        return $this->from(['file'=>File::tableName()]);
    }
    /**
     * @return $this
     * */
    public function queryClassName($className)
    {
        return $this->andOnCondition(['file.model_name'=>$className]);
    }
    /**
     * @return $this
     * */
    public function queryModel($model)
    {
        return $this->andOnCondition(['file.model_id'=>$model->primaryKey]);
    }
    /**
     * @return $this
     * */
    public function queryType($type)
    {
        return $this->andOnCondition(['file.type'=>$type]);
    }
}