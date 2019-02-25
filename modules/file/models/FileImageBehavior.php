<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;

use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class FileImageBehavior extends FileBehavior
{
    public function initBehaviour()
    {
        if(!$this->className)
            $this->className = $this->owner->className();
    }

    // уникальным является только этот метод из за ресайза, остальные похожи такие как удаления и аттач
    public $autoSetMainImage=true;
    public function saveFiles()
    {
        $model = $this->owner;
        foreach ($this->attributes as $attribute)
            if($model->$attribute)
            {
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $n=>$uploadedFile){
                        $type = FileImage::TYPE_IMAGE;
                        if($n==0 && $this->autoSetMainImage && !File::find()->queryModel($this->className)->queryModelId($model->id)->queryType(FileImage::TYPE_IMAGE_MAIN)->exists())
                            $type = FileImage::TYPE_IMAGE_MAIN;
                        FileImage::create($model, $uploadedFile, ['type'=>$type, 'model_name'=>$this->className]);
                    }
                else{
                    if($file = File::find()->queryModel($this->className)->queryModelId($model->id)->queryType(FileImage::TYPE_SINGLE_IMAGE)->one())
                        $file->delete();
                    FileImage::create($model, $model->$attribute, ['type'=>FileImage::TYPE_SINGLE_IMAGE, 'model_name'=>$this->className]);
                }
            }
    }


    public function deleteDir()
    {
        $this->deleteFiles();
        $modelName = (new \ReflectionClass($this->owner))->getShortName();
        $modelName = strtolower($modelName);
        $uploadFolder = (new File)->uploadFolder;
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}/thumb"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}/thumb");
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->id}");
    }

}