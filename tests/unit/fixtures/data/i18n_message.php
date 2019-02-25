<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

Yii::$app->language = 'ru';
$Agreement_text_ru = Yii::t('user', 'Agreement_text');

Yii::$app->language = Yii::$app->sourceLanguage;
$Agreement_text_en = Yii::t('user', 'Agreement_text');

$id=5;
return [
    [
        'id'=>1,
        'language'=>'ru',
        'translation'=>'Тема сообщения',
    ],
    [
        'id'=>2,
        'language'=>'en-US',
        'translation'=>$Agreement_text_en,
    ],
    [
        'id'=>2,
        'language'=>'ru',
        'translation'=>$Agreement_text_ru,
    ],

    [
        'id'=>3,
        'language'=>'ru',
        'translation'=>'Все категории',
    ],
    [
        'id'=>4,
        'language'=>'ru',
        'translation'=>'Назад ко всем категориям',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Электроника',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Компьютеры',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Телефоны',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Ноутбуки',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Стационарные компьютеры',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Планшеты',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Аксессуары для компьютеров',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Смартфоны',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Мобильные телефоны',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Аксессуары для смартфонов',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Чехлы для телефонов',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Зарядные устройства',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Продовольственные товары',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Газированные напитки',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Соки',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Женское нижнее белье',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Очки, оптика',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Очки для зрения',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Солнцезащитные очки',
    ],


    //back labels
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к электроникам',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к компьютерам',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к телефонам',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к аксессуарам для смартфонов',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к продовольственным товарам',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Назад к очкам, оптике',
    ],

    //all labels
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в электрониках',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в компьютерах',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в телефонах',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в аксессуарах для смартфонов',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в продовольственных товарах',
    ],
    [
        'id'=>$id++,
        'language'=>'ru',
        'translation'=>'Все в очках, оптике',
    ],

];