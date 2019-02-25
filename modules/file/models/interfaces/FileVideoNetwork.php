<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */



namespace file\models\interfaces;


interface FileVideoNetwork extends File
{
    public function getImg($options=[]);
    public function getVideo($options=['width'=>560, 'height'=>315]);
    public function getImageUrl();
}