<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use file\models\FileVideoNetwork;
use file\models\FileImage;

$date = date('Y-m-d H:i:s');

return [

    //articles
    array('model_id' => '2','model_name' => 'article\\models\\Article',
        'type' => FileVideoNetwork::TYPE_VIDEO_YOUTUBE,
        'file_name' => 'pgERwf8tqwc',
        'title' => 'Mac book video','created_at'=>$date,'updated_at'=>$date),

    array('model_id' => '4','model_name' => 'article\\models\\Article',
        'file_name' => '45fbc6d3e05ebd93369ce542e8f2322d.jpg',
        'title' => 'asus zenbook ux303u nw g05',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '4','model_name' => 'article\\models\\Article',
        'file_name' => '6cfe0e6127fa25df2a0ef2ae1067d915.jpg',
        'title' => 'zenbook-ux31-profile',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '4','model_name' => 'article\\models\\Article',
        'file_name' => '85fc37b18c57097425b52fc7afbb6969.jpg',
        'title' => 'asus zenbook ux303u',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '4','model_name' => 'article\\models\\Article',
        'file_name' => '5737034557ef5b8c02c0e46513b98f90.jpg',
        'title' => 'zenbook-ux31',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),

    //user
    array('model_id' => '1','model_name' => 'user\\models\\User',
        'file_name' => 'dd8eb9f23fbd362da0e3f4e70b878c16.jpg',
        'title' => 'large.jpg',
        'type' => FileImage::TYPE_SINGLE_IMAGE,'created_at'=>$date,'updated_at'=>$date),

    //pages
    array('model_id' => '1','model_name' => 'page\\models\\Page',
        'file_name' => '1ce927f875864094e3906a4a0b5ece68.jpg',
        'title' => 'Internet-magazin2.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),

    //categories
    array('model_id' => '2','model_name' => 'category\\models\\Category',
        'file_name' => '218a0aefd1d1a4be65601cc6ddc1520e.png','title' => 'f57a2f557b098c43f11ab969efe1504b.png',
        'type' => FileImage::TYPE_SINGLE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '3','model_name' => 'category\\models\\Category',
        'file_name' => '555d6702c950ecb729a966504af0a635.png','title' => 'e8c0653fea13f91bf3c48159f7c24f78.png',
        'type' => FileImage::TYPE_SINGLE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '13','model_name' => 'category\\models\\Category',
        'file_name' => 'eeb69a3cb92300456b6a5f4162093851.png','title' => 'a67f096809415ca1c9f112d96d27689b.png',
        'type' => FileImage::TYPE_SINGLE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '14','model_name' => 'category\\models\\Category',
        'file_name' => '8c6744c9d42ec2cb9e8885b54ff744d0.png','title' => 'ccc0aa1b81bf81e16c676ddb977c5881.png',
        'type' => FileImage::TYPE_SINGLE_IMAGE,'created_at'=>$date,'updated_at'=>$date),



    //comments
    array('model_id' => '1','model_name' => 'comment\\models\\Comment',
        'file_name' => 'c4015b7f368e6b4871809f49debe0579.jpg',
        'title' => '443cb001c138b2561a0d90720d6ce111.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '1','model_name' => 'comment\\models\\Comment',
        'file_name' => 'e56954b4f6347e897f954495eab16a88.jpg','title' => 'a8abb4bb284b5b27aa7cb790dc20f80b.jpg',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '1','model_name' => 'comment\\models\\Comment',
        'file_name' => 'TTTGiUi9Jfw','title' => '',
        'type' => FileVideoNetwork::TYPE_VIDEO_YOUTUBE,'created_at'=>$date,'updated_at'=>$date),



    //products
    array('model_id' => '1','model_name' => 'product\\models\\Product',
        'file_name' => '846c260d715e5b854ffad5f70a516c88.jpg','title' => 'asus-zenbook-3-ux390ua-01.jpg',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '1','model_name' => 'product\\models\\Product',
        'file_name' => '4a47d2983c8bd392b120b627e0e1cab4.jpg','title' => 'asus-zenbook-nx500.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '1','model_name' => 'product\\models\\Product',
        'file_name' => 'bf8229696f7a3bb4700cfddef19fa23f.jpg','title' => 'Zenbook+3+handson+gallery+1+2.jpg',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '1','model_name' => 'product\\models\\Product',
        'file_name' => '08c5433a60135c32e34f46a71175850c.jpg','title' => 'c4015b7f368e6b4871809f49debe0579.jpg',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),

    array('model_id' => '2','model_name' => 'product\\models\\Product',
        'file_name' => 'a8baa56554f96369ab93e4f3bb068c22.jpg','title' => 'MACBOOKPRO.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '3','model_name' => 'product\\models\\Product',
        'file_name' => '9c838d2e45b2ad1094d42f4ef36764f6.jpg','title' => '75fc093c0ee742f6dddaa13fff98f104.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '5','model_name' => 'product\\models\\Product',
        'file_name' => 'd96409bf894217686ba124d7356686c9.jpg','title' => 'safe_image.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '6','model_name' => 'product\\models\\Product',
        'file_name' => 'f770b62bc8f42a0b66751fe636fc6eb0.jpg','title' => 'p8482c.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '7','model_name' => 'product\\models\\Product',
        'file_name' => '1fc214004c9481e4c8073e85323bfd4b.jpg','title' => 'p8225a.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '8','model_name' => 'product\\models\\Product',
        'file_name' => '1141938ba2c2b13f5505d7c424ebae5f.jpg','title' => 'Fanta_1500ml.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '9','model_name' => 'product\\models\\Product',
        'file_name' => 'f9b902fc3289af4dd08de5d1de54f68f.jpg','title' => 'copy-Fanta_1500ml.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),

    array('model_id' => '10','model_name' => 'product\\models\\Product',
        'file_name' => '1700002963a49da13542e0726b7bb758.jpg','title' => '95eed8_38d15dc82acc42ea92bd621141c91199_mv2_d_1500_2000_s_2.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '10','model_name' => 'product\\models\\Product',
        'file_name' => 'a597e50502f5ff68e3e25b9114205d4a.jpg','title' => '95eed8_c05104474cd843f799a3fb1b990af1e5_mv2_d_1500_2000_s_2.jpg',
        'type' => FileImage::TYPE_IMAGE,'created_at'=>$date,'updated_at'=>$date),

    array('model_id' => '11','model_name' => 'product\\models\\Product',
        'file_name' => 'd7a728a67d909e714c0774e22cb806f2.jpg','title' => 'Agent-Provocateur-Korset-Stevie.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '12','model_name' => 'product\\models\\Product',
        'file_name' => '1fc214004c9481e4c8073e85323bfd4b.jpg','title' => '99.970.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '13','model_name' => 'product\\models\\Product',
        'file_name' => '8e6b42f1644ecb1327dc03ab345e618b.jpg','title' => 'card_003780_7pml.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '15','model_name' => 'product\\models\\Product',
        'file_name' => '7f100b7b36092fb9b06dfb4fac360931.jpeg','title' => 'images.jpeg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),
    array('model_id' => '16','model_name' => 'product\\models\\Product',
        'file_name' => 'df877f3865752637daa540ea9cbc474f.jpg','title' => 'copy_hp_k0b38aa_585a5de83acf9_images_1810131309.jpg',
        'type' => FileImage::TYPE_IMAGE_MAIN,'created_at'=>$date,'updated_at'=>$date),

];