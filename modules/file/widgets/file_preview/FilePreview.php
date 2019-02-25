<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace file\widgets\file_preview;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class FilePreview extends Widget
{
    public $thumbType='xs';
    public $image;
    public $images;
    public $video;
    public $actions=true;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        \kartik\file\FileInputAsset::register(Yii::$app->view);
        \common\assets\LightboxAsset::register(Yii::$app->view);
        \file\widgets\file_video_network\assets\FileVideoNetworkAsset::register(Yii::$app->view);
        if($this->images)
            return $this->render("file_preview_images", ['images'=>$this->images, 'thumbType'=>$this->thumbType,
                'actions'=>$this->actions]);
        if($this->image)
            return $this->render("file_preview_image", ['image'=>$this->image, 'thumbType'=>$this->thumbType,
                'actions'=>$this->actions]);
        if($this->video){
            return $this->render("file_preview_video", ['video'=>$this->video, 'options'=>[],
                'actions'=>$this->actions]);
        }

    }
}