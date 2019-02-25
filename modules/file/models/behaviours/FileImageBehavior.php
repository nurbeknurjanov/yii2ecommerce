<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\behaviours;

use file\models\File;
use file\models\FileImage;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class FileImageBehavior extends FileBehavior
{
    public $type=FileImage::TYPE_IMAGE;

    public $autoSetMainImage=true;
    public $loader=FileImage::class;
    public function saveFiles()
    {
        $model = $this->owner;
        $loader = $this->loader;
        /* @var FileImage $loader */
        foreach ($this->fileAttributes as $attribute)
            if($model->$attribute){
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $n=>$uploadedFile){
                        $type = $loader::TYPE_IMAGE;
                        if($n==0 && $this->autoSetMainImage &&
                            !$loader::find()->queryClassName($this->className)
                                ->queryModel($model)
                                ->queryMainImage()->exists())
                            $type = $loader::TYPE_IMAGE_MAIN;
                        $loader::create($model, $uploadedFile, ['type'=>$type, 'model_name'=>$this->className]);
                    }
                else{
                    if($file = $loader::find()
                        ->queryClassName($this->className)
                        ->queryModel($model)
                        ->queryImage()->one())
                        $file->delete();
                    $loader::create($model, $model->$attribute, ['type'=>$loader::TYPE_SINGLE_IMAGE,'model_name'=>$this->className]);
                }
            }
    }


    public function deleteDir()
    {
        $this->deleteFiles();
        $modelName = (new \ReflectionClass($this->owner))->getShortName();
        $modelName = strtolower($modelName);
        $uploadFolder = (new File)->uploadFolder;
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}/thumb"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}/thumb");
        if(is_dir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}"))
            rmdir(Yii::getAlias('@frontend')."/web/$uploadFolder/$modelName/{$this->owner->primaryKey}");
    }

}