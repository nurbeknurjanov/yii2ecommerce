<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use article\models\Article;

$date = date('Y-m-d H:i:s');

return [
    [
        'id' => '1','type' => Article::TYPE_NEWS,
        'title' => 'Asus claims the ZenBook 13 UX331UN is currently the world\'s thinnest laptop with discrete graphics.',
        'text' => '<p>Asus claims the ZenBook 13 UX331UN is currently the world\'s thinnest laptop with discrete graphics.

If you\'re not sure why you should care about that, it\'s because it shows we\'ve finally reached a point where you can get an ultraportable laptop with long battery life without sacrificing graphics performance or spending a ton of money. 

WIth laptops that are half an inch (12.7 mm) thick like the ZenBook 13 ($979.05 at Amazon.com), you\'d typically get integrated graphics that are more power efficient, run cooler and cost less than a standalone discrete graphics chip. The downsides are integrated graphics also eat into your system memory and just can\'t handle more demanding graphics tasks or gaming. Though the Nvidia GeForce MX150 chip used here is entry level, it has 2GB of its own memory, and Nvidia says it can deliver up to four times faster performance over integrated graphics for photo and video editing as well as deliver better gaming performance.</p>
',
        'created_at' => $date,'updated_at' => $date
    ],


    [
        'id' => '2','type' => Article::TYPE_NEWS,
        'title' => 'MacBook Pro 2018 release date, price, features, specs',
        'text' => 'The MacBook Pro lineup was updated on 7 June 2017 at WWDC 2017. At the time, Apple\'s Pro laptops gained faster Kaby Lake processors, but not everyone was happy with the update. Read on to find out people were disappointed, and how Apple could be addressing the complaints with new features in the 2018 update to the MacBook Pro range.

One thing we know for sure is that Apple is aware of the complaints: In November 2017 Apple\'s head of design Jony Ive admitted to being aware of the disappointment and criticism regarding the MacBook models.','created_at' => $date,'updated_at' => $date
    ],

    [
        'id' => '3','type' => Article::TYPE_ARTICLE,'title' => 'New iPhone 2018 release date, price & specs rumours',
        'text' => 'Apple\'s iPhone update in the autumn of 2018 could see three or even four new iPhones launched at the same time, and fans can\'t wait to see what\'s in store.

In this article we look at all the rumours concerning the successor to the iPhone X, and the expected larger iPhone X Plus: their release date, prices (which may be lower than expected, if Apple releases the rumoured iPhone X Lite), design changes, tech specs and new features. We\'ve also got the latest leaked photos, including what is believed to be a prototype iPhone X Plus display.

We also think Apple is likely to update the iPhone SE in the spring of 2018, and we have a separate article addressing those rumours here: iPhone SE 2 news. And for advice related to the current lineup, you may prefer to read our iPhone buying guide and roundup of the best iPhone deals.',
        'created_at' => $date,'updated_at' => $date
    ],

    [
        'id' => '4','type' => Article::TYPE_NEWS,
        'title' => 'Asus’ new ZenBook 13 is the world’s thinnest laptop with a dedicated GPU',
        'text'=>'Asus has unleashed a new spin on its ultraportable ZenBook 13, which the company is claiming is the world’s thinnest notebook with a discrete graphics card (in other words, a more powerful separate GPU as opposed to integrated graphics).
    
    The Asus ZenBook 13 UX331 was revealed at CES back at the start of the year, weighing just 985g, and this new model adds in a discrete GeForce MX150 for extra pixel-pushing power.
    
    Naturally enough, this means it’s slightly heftier, but still very trim at just 1.12kg, with a thickness of 14mm, meaning that it still easily qualifies as an Ultrabook.'
        ,'created_at' => $date,'updated_at' => $date
    ],
];
