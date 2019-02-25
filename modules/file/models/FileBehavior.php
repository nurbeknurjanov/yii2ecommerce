<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;

use yii\base\Behavior;
use yii\base\Event;
use yii\base\Exception;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class FileBehavior extends Behavior
{
    public $className;
    public $type;
    public function initBehaviour()
    {
        if(!$this->className)
            $this->className = $this->owner->className();
        if(!$this->type)
            throw new Exception("Type must be identified.", 400);
    }
    public $attributes=[];
    public function attachFiles()
    {
        foreach ($this->attributes as $attribute)
            if(is_array($this->owner->$attribute))
                $this->owner->$attribute = UploadedFile::getInstances($this->owner, $attribute);
            else
                $this->owner->$attribute = UploadedFile::getInstance($this->owner, $attribute);
    }
    // уникальным является только этот метод из за ресайза, остальные похожи такие как удаления и аттач
    public function saveFiles()
    {
        $model = $this->owner;
        foreach ($this->attributes as $attribute)
            if($model->$attribute)
            {
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $uploadedFile)
                        File::create($model, $uploadedFile, ['type'=>$this->type, 'model_name'=>$this->className]);
                else{
                    if($file = File::find()->queryModel($this->className)->queryModelId($model->id)->queryType(FileImage::TYPE_SINGLE_IMAGE)->one())
                        $file->delete();
                    File::create($model, $model->$attribute, ['type'=>$this->type, 'model_name'=>$this->className]);
                }
            }
    }
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT=>[$this->owner, 'initBehaviour'],
            ActiveRecord::EVENT_BEFORE_VALIDATE=>[$this->owner, 'attachFiles'],
            ActiveRecord::EVENT_AFTER_INSERT=>[$this->owner, 'saveFiles'],
            ActiveRecord::EVENT_AFTER_UPDATE=>function(Event $event){
                    /* @var $model \user\models\User */
                    $model = $event->sender;
                    //$model = $this->owner;
                    $model->saveFiles();
                },
            ActiveRecord::EVENT_BEFORE_DELETE=>[$this->owner, 'deleteDir'],
        ];
    }

    public function deleteFiles()
    {
        foreach ($this->attributes as $attribute)
            if(is_array($this->owner->$attribute)){
                $attribute = str_replace('Attribute', '', $attribute);
                foreach($this->owner->$attribute as $file)
                    $file->delete();
            }
            else{
                $attribute = str_replace('Attribute', '', $attribute);
                if($this->owner->$attribute)
                    $this->owner->$attribute->delete();
            }
    }
    public function deleteDir()
    {
        $this->deleteFiles();
        $modelName = (new \ReflectionClass($this->owner))->getShortName();
        $modelName = strtolower($modelName);
        $uploadFolder = (new File)->uploadFolder;
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}");
    }

}