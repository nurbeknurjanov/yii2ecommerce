<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */



namespace file\models\interfaces;


interface FileImage extends File
{
    public function getImg($thumbType='xs', $options=[]);
    public function getThumbUrl(string $type='xs');
    public function getImageUrl();
}