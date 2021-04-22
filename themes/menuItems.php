<?php
use yii\helpers\Html;
use order\models\Basket;
use favorite\models\FavoriteLocal;
use product\models\Compare;
use i18n\models\I18nSourceMessage;
use yii\helpers\Inflector;

$request = Yii::$app->request;

$left = [
    ['label' => Yii::t('common', 'About us'),
        'url' => ['/page/page/view', 'page_title_url'=>'about_us'],
        'active'=>$request->get('page_title_url')=='about_us'],
    ['label' => Yii::t('product', 'Products'), 'url' => ['/product/product/list']],
];

//profile
if (Yii::$app->user->isGuest)
    $profile = ['label' => Yii::t('common', 'Login'), 'url' => ['/user/guest/login']];
else
    $profile = [
        'label' => Yii::$app->user->identity->fullName,
        'visible'=>true,
        'items'=>[
            ['label' => Yii::t('user', 'My profile'), 'url' => ['/user/profile/profile']],
            ['label' => Yii::t('user', 'Edit profile'), 'url' => ['/user/profile/edit-profile',]],
            ['label' => Yii::t('user', 'Change email'), 'url' => ['/user/profile/change-email']],
            Yii::$app->user->identity->password_hash ? ['label' => Yii::t('user', 'Change password') , 'url' => ['/user/profile/change-password']]:['label' => Yii::t('user', 'Set password'), 'url' => ['/user/profile/set-password']],
            ['label' => Yii::t('user', 'Share link to register'), 'url' => ['/user/profile/share',]],
            ['label' => Yii::t('user', 'Invite to register'), 'url' => ['/user/profile/invite',]],
            ['label' =>
                Yii::t('common', 'Logout'),
                'url' => ['/user/profile/logout'],
                'linkOptions' => ['data-method' => 'post']],
        ],
    ];

//favorite
$favoriteTitle = '<i class="glyphicon glyphicon-heart"></i> '.
    Html::tag('span', Yii::t('favorite', 'Favorites'), ['class'=>'caption']).
    '('.Html::tag('span', FavoriteLocal::getNProducts(), ['id'=>'favoriteCountSpan',]).')';
$favorite = ['label' => $favoriteTitle, 'url' => ['/product/product/favorites'], 'options'=>['class'=>'']];

//compare
$compareTitle = '<i class="glyphicon glyphicon-stats"></i> '.
    Html::tag('span', Yii::t('product', 'Compare products'), ['class'=>'caption']).
    '('.Html::tag('span', Compare::getNProducts(), ['id'=>'compareCountSpan',]).')';
$compare = ['label' => $compareTitle, 'url' => ['/product/compare/index']];

//languages
$languageItems = $languages = (new I18nSourceMessage)->languageValues;
array_walk($languageItems, function(&$value, $key) { $value = [
    'label'=> $value,
    'url'=>[ "/".Yii::$app->controller->route]+$_GET+['language'=>$key],
    'active'=>Yii::$app->language==$key,
]; });
$language = [
    'dropDownOptions'=>[
        'id'=>'menu-language',
    ],
    'label' => $languages[Yii::$app->language],
    'items'=>$languageItems
];

//themes
$themes = [];
//foreach(glob(Yii::getAlias('@themes').'/*', GLOB_ONLYDIR) as $dir)
foreach(['sakura', 'sakura_light', 'bootstrap'] as $theme){
    //$name = basename($dir);
    $themes[]=[
        'label'=>Inflector::camel2words($theme),
        'url'=>['/'.Yii::$app->controller->route]+$_GET+['theme'=>$theme],
        'active'=>$this->theme->id==$theme,
    ];
}
$theme = [
    'dropDownOptions'=>[
        'id'=>'menu-theme',
    ],
    'label' => Yii::t('common', 'Theme'),
    'items' => $themes
];


$right = [
    /*'<li class="phoneTop"><i class="glyphicon glyphicon-phone-alt"></i>
            +996 (558) 01-14-77</li>',*/
    [
        'label' => '<i class="glyphicon glyphicon-list-alt"></i> '.Yii::t('order', 'My orders'),
        'url' => ['/order/order/list'],
        'active'=>in_array(Yii::$app->controller->route, ['order/order/list', 'order/order/view'])
    ],
    $favorite,
    $compare,
    $profile,
    $language,
    $theme
];


return [
    'left'=>$left,
    'right'=>$right
];