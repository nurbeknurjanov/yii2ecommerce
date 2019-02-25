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
$leftItems = [
    ['label' => Yii::t('common', 'About us'), 'url' => ['/page/page/view', 'url'=>'about_us'],
        'active'=>$request->get('url')=='about_us'],
    ['label' => Yii::t('common', 'Guarantee'), 'url' => ['/page/page/view', 'url'=>'guarantee'], 'active'=>$request->get('url')=='guarantee'],
    ['label' => Yii::t('common', 'Delivery & payment'), 'url' => ['/page/page/view', 'url'=>'delivery'], 'active'=>$request->get('url')=='delivery'],
    ['label' => Yii::t('common', 'Feedback'), 'url' => ['/site/contact']]
];
NavBar::begin([
    'brandLabel' => false,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default navbar-top',
    ],
]);
echo Nav::widget([
    'encodeLabels'=>false,
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $leftItems,
]);
echo Nav::widget([
    'encodeLabels'=>false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items['rightItems'],
]);
NavBar::end();

?>
<nav id="top-menu" style="display: none;" >
    <?php
    $this->registerJs("
            var Back_to_home='".Yii::t('common', 'Back to home')."';
            ", $this::POS_HEAD);
    $rightItems = $items['rightItems'];
    array_walk($rightItems, function(&$value, $key) {
        $value['linkOptions']=[ 'class'=>['widget'=>'']  ];
        $value['options']=[ 'class'=>['widget'=>'']  ];
        $value['dropDownOptions']=[ 'class'=>['widget'=>'']  ];
    });
    $items = array_merge([
        [
            'label'=>Yii::t('common', 'Home'),
            'url'=>['/'],
        ],
    ],$leftItems, $rightItems);
    echo Nav::widget([
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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w29-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            $route = Yii::$app->controller->route;
            if($route!='site/index'
                && $route!='product/product/list'
                && $route!='product/product/view'
            )
                echo Html::a($this->title, '', ['class'=>'navbar-brand']);
            ?>
        </div>
    </div>
</div>

