<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 11/6/16
 * Time: 11:57 AM
 */

namespace file\widgets\file_video_network;

use file\widgets\file_video_network\assets\FileVideoNetworkAsset;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class FileVideoNetworkWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        FileVideoNetworkAsset::register(Yii::$app->view);
        return $this->render("file-video-network");
    }
}