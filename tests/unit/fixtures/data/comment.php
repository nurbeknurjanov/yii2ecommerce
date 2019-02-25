<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

$date = date('Y-m-d H:i:s');

return [
    array('id' => '1','model_id' => '1',
        'model_name' => 'product\\models\\Product',
        'user_id' => NULL,
        'ip' => '127.0.0.1',
        'name' => 'Adam Smith',
        'text' => 'One of the best laptop values around, Asus\' 13-inch ZenBook UX330UA provides premium specs -- such as a lightweight aluminum chassis, a vibrant 1080p screen and a 256GB solid-state drive -- for well under $800. A successor to last year\'s identically named model, the late-2017 version of the UX330UA upgrades the processor to a zippy Intel 8th-Gen Core i5 CPU while keeping everything else the same. Unfortunately, the added performance means 1.5 hours less battery life. But with its colorful screen, sweet audio and 2.7-pound chassis, the ZenBook UX330UA is still a great choice for anyone who needs a lightweight Ultrabook at an affordable price.',
        'created_at'=>$date,'updated_at'=>$date,
        'enabled'=>1,),
    array('id' => '2','model_id' => '1',
        'model_name' => 'product\\models\\Product',
        'user_id' => NULL,
        'ip' => '127.0.0.2',
        'name' => 'Danma Musa Williams',
        'text' => 'A student of Liberia. I have been suffering too long now with laptops I buy but don\'t last. poor battery life, crashing of hard drive and screen, poor wifi connection have been among the problems. I will appreciate your advice on my purchase of a laptop preventing these previous experiences.',
        'created_at'=>$date,'updated_at'=>$date,
        'enabled'=>1,),
    array('id' => '3','model_id' => '1',
        'model_name' => 'product\\models\\Product',
        'user_id' => NULL,
        'ip' => '127.0.0.3',
        'name' => 'Johny',
        'text' => 'Thanks for the review. What I miss from most laptop/ultrabook reviews, including this one, is a test with external monitors (2560x1440 and up). I want to replace my desktop workstation with an ultrabook but the Ultrabook must support my 2560x1440 external monitor but surprisingly few does! (HDMI single link bandwidth is not enough for 2560x1440@60Hz).',
        'created_at'=>$date,'updated_at'=>$date,
        'enabled'=>1,)
];