<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace category\models;

use yii\helpers\Html;

use file\models\FileImage;

class FileImageCategory extends FileImage
{
    public function getImg($thumbType=false, $options=[])
    {
        return Html::img($this->imageUrl, $options);
    }

    public $thumbXs=false;
    public $thumbSm=false;
    public $thumbMd=false;

    public $imageWidth=50;
    public $imageHeight=50;
}