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
    public $padding = false;
    public $thumbSm=false;
    public $thumbMd=false;

    public $thumbXsWidth=177;
    public $thumbXsHeight=50;

    public $imageWidth=825;
    public $imageHeight=233;

    public function init()
    {
        parent::init();
        $this->on(static::EVENT_AFTER_DELETE, [Category::class, 'deleteCache']);
    }
}