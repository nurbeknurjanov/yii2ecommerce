<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\imagine;


class Imagine
{
    public static function pad($fileUrl, \Imagine\Image\Box $box)
    {
        $image = new \Imagine\Gd\Imagine();
        $image = $image->open($fileUrl);

        $idealSize = $box;
        $currentSize = $image->getSize();
        $x = $y = 0;
        if ($idealSize->getWidth() > $currentSize->getWidth())
            $x =  round(($idealSize->getWidth() - $currentSize->getWidth()) / 2);
        /*elseif*/
        if($idealSize->getHeight() > $currentSize->getHeight())
            $y = round(($idealSize->getHeight() - $currentSize->getHeight()) / 2);

        $gdImagine = new \Imagine\Gd\Imagine();
        $newBlankImage = $gdImagine->create($box, new \Imagine\Image\Color("#fff", 100));
        $newBlankImage->paste($image, new \Imagine\Image\Point($x, $y))->save($fileUrl, ['quality'=>100]);

    }
}