<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\behaviours;

use extended\helpers\Inflector;
use extended\helpers\StringHelper;
use file\models\File;
use file\models\FileImage;
use yii\base\Event;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;
use extended\helpers\Html;

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


    /*
     * return default image
     * */
    public function getThumbImg(string $thumbType, $options=[], $width='auto', $height='auto')
    {
        $model = $this->owner;

        $thumbAttribute = 'thumb'.ucfirst($thumbType);
        if((new $this->loader)->$thumbAttribute===false)
            throw new Exception("There is no $thumbType thumb type for ".Inflector::titleize(StringHelper::basename($model::className()), true));

        if(!isset($options['alt']))
            $options['alt']=$model->title;


        $cssSize = "width:{$width};height:{$height};";
        if(isset($options['style']))
            $options['style'].=$cssSize;
        else
            $options['style']=$cssSize;
        if($model->image)
            return $model->image->getThumbImg($thumbType, $options);

        if($width=='auto'){
            $widthAttribute = 'thumb'.ucfirst($thumbType).'Width';
            $width = (new $this->loader)->$widthAttribute;
        }
        if($height=='auto'){
            $heightAttribute = 'thumb'.ucfirst($thumbType).'Height';
            $height = (new $this->loader)->$heightAttribute;
        }

        return Html::noImg($width, $height, $options);
    }
    public function getImageImg($options=[], $width='auto', $height='auto')
    {
        $model = $this->owner;
        if(!isset($options['alt']))
            $options['alt']=$model->title;


        $cssSize = "width:{$width};height:{$height};";
        if(isset($options['style']))
            $options['style']=$cssSize.$options['style'];
        else
            $options['style']=$cssSize;

        if($model->image)
            return $model->image->getImageImg($options);

        if($width=='auto')
            $width = (new $this->loader)->imageWidth;

        if($height=='auto')
            $height = (new $this->loader)->imageHeight;

        return Html::noImg($width, $height, $options);
    }
}