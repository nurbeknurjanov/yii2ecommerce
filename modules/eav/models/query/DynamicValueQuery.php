<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\models\query;

use category\models\Category;
use eav\models\DynamicField;
use eav\models\DynamicValue;
use yii\db\Expression;
use yii\helpers\ArrayHelper;



class DynamicValueQuery extends  \yii\db\ActiveQuery
{


    public function defaultFrom()
    {
        return $this->from(['dynamic_value'=>DynamicValue::tableName()]);
    }

    public function fieldQuery(DynamicValue $valueModel)
    {
        $newQuery = new DynamicValueQuery(DynamicValue::class);
        $newQuery->valueQuery($valueModel);
        return $this->andWhere(['AND', ['dynamic_value.field_id'=>$valueModel->field_id], $newQuery->where]);
    }
    public function valueQuery(DynamicValue $valueModel)
    {
        if($valueModel->value){
            if(is_array($valueModel->value) || $valueModel->field->isMultiple){
                $condition=[];
                foreach ((array) $valueModel->value as $val)
                    $condition[] = "FIND_IN_SET('$val', dynamic_value.value)";
                if($condition)
                    $this->andWhere(implode(" OR ", $condition));
            }
            else
                $this->andFilterWhere(["dynamic_value.value"=>$valueModel->value]);
        }else{
            if($valueModel->valueFrom)
                $this->andWhere(new Expression("dynamic_value.value>=$valueModel->valueFrom"));
            if($valueModel->valueTo)
                $this->andWhere(new Expression("dynamic_value.value<=$valueModel->valueTo"));
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return \eav\models\DynamicValue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \eav\models\DynamicValue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
} 