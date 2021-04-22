<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 12/9/18
 * Time: 2:03 AM
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$items = require(Yii::getAlias('@themes').'/menuItems.php');
$request = Yii::$app->request;
$left = [
    ['label' => Yii::t('common', 'About us'), 'url' => ['/page/page/view', 'page_title_url'=>'about_us']],
    ['label' => Yii::t('common', 'Guarantee'), 'url' => ['/page/page/view', 'page_title_url'=>'guarantee']],
    ['label' => Yii::t('common', 'Delivery & payment'),
        'url' => ['/page/page/view', 'page_title_url'=>'delivery']],
    ['label' => Yii::t('common', 'Feedback'), 'url' => ['/site/contact']],
    //['label' => 'Test', 'url' => ['/site/test']],
];
NavBar::begin([
    'id'=>'top-menu-widget',
    'brandLabel' => false,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default navbar-top',
    ],
]);
echo Nav::widget([
    'id'=>'top-menu-widget-content-left',
    'encodeLabels'=>false,
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $left,
]);
echo Nav::widget([
    'id'=>'top-menu-widget-content-right',
    'encodeLabels'=>false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items['right'],
]);
NavBar::end();
?>




<nav id="top-menu-widget2" style="display: none;" >
    <?php
    $this->registerJs("
            var Back_to_home='".Yii::t('common', 'Back to home')."';
            ", $this::POS_HEAD);
    $right = $items['right'];
    array_walk($right, function(&$value, $key) {
        $value['linkOptions']=[ 'class'=>['widget'=>'']  ];
        $value['options']=[ 'class'=>['widget'=>'']  ];
        $value['dropDownOptions']=[
            'class'=>['widget'=>''],
            'id'=>'m'.$key,
        ];
    });
    $items = array_merge([
        [
            'label'=>Yii::t('common', 'Home'),
            'url'=>['/'],
        ],
    ],$left, $right);
    echo Nav::widget([
        'id'=>'top-menu-widget2-content',
        'dropDownCaret'=>false,
        'encodeLabels'=>false,
        'options' => ['class' => ['widget'=>'',]],
        'items' => $items,
    ]);
    ?>
</nav>
<div class="navbar navbar-default navbar-menu-top-hidden">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" ><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="javascript:void(0)" class="navbar-brand">
                <?php
                if(isset($this->params['topTitle']))
                    echo $this->params['topTitle'];
                ?>
            </a>
        </div>
    </div>
</div>