<?php

namespace extended\behaviours;

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 2/28/18
 * Time: 10:40 AM
 */



use product\models\Product;
use yii\base\Exception;
use yii\db\ActiveRecord;

class ManyToManyBehaviour extends \yii\base\Behavior
{
    public function init()
    {
        parent::init();
        if(!$this->manyAttribute)
            throw new Exception("manyAttribute must be set.");
        if(!$this->saveFunction)
            throw new Exception("manyAttribute must be set.");
    }

    public $manyAttribute;
    public $manyAttributeOldValue;
    public $saveFunction;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT=>[$this, 'callSaveFunction'],
            ActiveRecord::EVENT_AFTER_UPDATE=>[$this, 'callSaveFunction'],
        ];
    }

    public function callSaveFunction()
    {
        $attribute = $this->manyAttribute;
        /* @var Product $model */
        $model = $this->owner;
        $model->setAttribute($attribute, $model->$attribute);
        $model->setOldAttribute($attribute, $this->manyAttributeOldValue);
        if($model->isAttributeChanged($attribute)){
            call_user_func( [ $model, $this->saveFunction] );
        }
    }
}