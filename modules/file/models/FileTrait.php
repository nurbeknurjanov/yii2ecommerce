<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;


use category\models\Category;
use category\models\FileImageCategory;
use file\models\search\FileSearch;
use yii\helpers\ArrayHelper;
use file\widgets\file_preview\FilePreview;

trait FileTrait
{
    public function getAllTypeValues()
    {
        return ArrayHelper::merge((new File)->typeValues, (new FileImage)->typeValues, (new FileVideoNetwork)->typeValues);
    }
    public function getIcon($options=[])
    {
        /**
         * @var File $this
         */
        switch(true){
            case $this->type==File::TYPE_AUDIO:{
                break;
            }
            case $this->type==File::TYPE_DOC:{
                break;
            }
            case in_array($this->type, array_keys((new FileVideoNetwork)->typeValues)):{
                $fileVideoNetwork = new FileVideoNetwork($this->attributes);
                return FilePreview::widget(['video'=>$fileVideoNetwork, 'actions'=>false]);
            }
            case in_array( $this->type, [FileImage::TYPE_SINGLE_IMAGE, FileImage::TYPE_IMAGE_MAIN, FileImage::TYPE_IMAGE]):{
                $fileImage = new FileImage();
                $fileImage->attributes = $this->attributes;
                if($fileImage->model_name==Category::class){
                    $fileImage = new FileImageCategory();
                    $fileImage->attributes = $this->attributes;
                    return FilePreview::widget(['image'=>$fileImage, 'actions'=>false]);
                }
                return FilePreview::widget(['image'=>$fileImage, 'actions'=>false]);
                break;
            }
        }
    }
} 