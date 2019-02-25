<?php

namespace tag\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;


/**
 * This is the model class for table "object_tag".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $model_name
 * @property integer $tag_id
 */
class ObjectTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_tag';
    }

    public static function createIfNotExists($model_name, $model_id, $tag_id)
    {
        if(!self::findOne(['model_name'=>$model_name,'model_id'=>$model_id, 'tag_id'=>$tag_id])){
            $model = new self(['model_name'=>$model_name,'model_id'=>$model_id, 'tag_id'=>$tag_id]);
            if(!$model->save())
                throw new Exception(Html::errorSummary($model));
        }
    }



    public function init()
    {
        parent::init();
        //$this->on(static::EVENT_BEFORE_INSERT, [$this, 'someFunction']);
        //$this->on(static::EVENT_BEFORE_UPDATE, [$this, 'someFunction']);
        /*
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            // @var $model self
            $model = $event->sender;
        });
        */

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_name', 'tag_id'], 'required'],
            [['model_id', 'tag_id'], 'integer'],
            [['model_id', 'tag_id'], 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'model_id' => Yii::t('common', 'Model ID'),
            'model_name' => Yii::t('common', 'Model Name'),
            'tag_id' => Yii::t('common', 'Tag ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \tag\models\query\ObjectTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \tag\models\query\ObjectTagQuery(get_called_class());
    }



}