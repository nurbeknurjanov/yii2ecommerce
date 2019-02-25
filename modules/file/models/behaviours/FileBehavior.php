<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\behaviours;

use file\models\File;
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
    public function init()
    {
        if(!$this->className)
            throw new Exception("Class name must be set.", 400);
        if(!$this->type)
            throw new Exception("Type must be identified.", 400);
        if(!$this->fileAttributes)
            throw new Exception("FileAttributes must be identified.", 400);
        parent::init();
    }

    public $fileAttributes=[];
    public function attachFiles()
    {
        foreach ($this->fileAttributes as $attribute){
            if(is_array($this->owner->$attribute))
                $this->owner->$attribute = array_filter($this->owner->$attribute);
            if(!$this->owner->$attribute){
                if(is_array($this->owner->$attribute))
                    $this->owner->$attribute = UploadedFile::getInstances($this->owner, $attribute);
                else
                    $this->owner->$attribute = UploadedFile::getInstance($this->owner, $attribute);
            }
        }
    }

    public function saveFiles()
    {
        $model = $this->owner;
        foreach ($this->fileAttributes as $attribute)
            if($model->$attribute)
            {
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $uploadedFile)
                        File::create($model, $uploadedFile, ['type'=>$this->type, 'model_name'=>$this->className]);
                else{
                    if($file = File::find()->queryClassName($this->className)
                        ->queryModel($model)->queryType($this->type)->one())
                        $file->delete();
                    File::create($model, $model->$attribute, ['type'=>$this->type, 'model_name'=>$this->className]);
                }
            }
    }
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE=>[$this->owner, 'attachFiles'],
            ActiveRecord::EVENT_AFTER_INSERT=>[$this->owner, 'saveFiles'],
            ActiveRecord::EVENT_AFTER_UPDATE=>[$this->owner, 'saveFiles'],
            ActiveRecord::EVENT_AFTER_DELETE=>[$this->owner, 'deleteDir'],
        ];
    }

    public function deleteDir()
    {
        $this->deleteFiles();
        $modelName = (new \ReflectionClass($this->owner))->getShortName();
        $modelName = strtolower($modelName);
        $uploadFolder = (new File)->uploadFolder;
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}");
    }
    public function deleteFiles()
    {
        foreach ($this->fileAttributes as $attribute){
            $attribute = str_replace('Attribute', '', $attribute);
            if($this->owner->$attribute){
                if(is_array($this->owner->$attribute))
                    foreach($this->owner->$attribute as $file)
                        $file->delete();
                else
                    $this->owner->$attribute->delete();
            }
        }
    }
}