<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 12/9/18
 * Time: 2:01 AM
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use order\models\Basket;
use favorite\models\FavoriteLocal;
use category\models\Category;
use extended\helpers\MenuTree;
use extended\helpers\Tree;
use common\assets\MenuAsset;

?>
<?php
$categories = Category::getDb()->cache(function ($db) {
    return Category::find()->defaultOrder()->enabled()->indexBy('id')->with('image')->all();
}/*,$duration, $dependency*/);


$results = ArrayHelper::toArray($categories,[
    Category::class => [
        'id' => function (Category $model) {
            return $model->id;
        },
        'title',
        'label' => function (Category $model) {
            $title = $model->title;
            //$title = $model->t('title');
            if($model->image)
                $title = Html::img($model->image->imageUrl, ['class'=>'category-icon']).$title;
            return $title;
        },
        'title_url',
        'text',
        'data',
        'tree_position',
        'product_count',
        'enabled',

        'tree',
        'lft',
        'rgt',
        'depth',

        'url' => function (Category $model) {
            return $model->getUrl();
        },
        'data-url' => function (Category $model) {
            return $model->getUrl();
        },
        'linkOptions'=>function (Category $model) {
            $linkOptions=[
                'data-toggle'=>'',//not possible
                'class'=> ['widget'=>''],
            ];
            if($model->depth==1)
                $linkOptions['class'] = ['widget'=>'bold'];
            return $linkOptions;
        },
        'dropDownOptions'=>function (Category $model) {
            return [
                //'class'=>['widget'=>''],
                'id'=>'c'.$model->id,
            ];
        },
        'active'=>function (Category $model) {
            return $model->id==Yii::$app->request->get('category_id');
        },
        'isLeaf'=>function (Category $model) {
            return $model->isLeaf;
        },
    ],
]);
$items=[];
if($results)
    $items = (new MenuTree)->tree($results);
NavBar::begin([
    'id'=>'category-menu-widget',
    'brandLabel' => false,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar '.($this->theme->id=='sakura' ? 'navbar-inverse':'navbar-default').' navbar-menu',
    ],
]);
echo Nav::widget([
    'id'=>'category-menu-widget-content',
    'encodeLabels'=>false,
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $items,
]);
NavBar::end();
?>
<div id="shadow"></div>


<?php
$results = ArrayHelper::toArray($categories,[
    Category::class => [
        'id' => function (Category $model) {
            return $model->id;
        },
        'title',
        'oldTitle' => function (Category $model) {
            return $model->getOldAttribute('title');
        },
        'label' => function (Category $model) {
            return $model->title;
            //return $model->t('title');
        },
        'title_url',
        'text',
        'data',
        'tree_position',
        'product_count',
        'enabled',

        'tree',
        'lft',
        'rgt',
        'depth',
        'url' => function (Category $model) {
            if(!$model->isLeaf)
                return '#';
            return $model->getUrl();
        },
        'data-url' => function (Category $model) {
            return $model->getUrl();
        },
        'linkOptions'=>function (Category $model) {
            $linkOptions['class']=['widget'=>''];
            if($model->depth==1)
                $linkOptions['class'] = ['widget'=>'bold'];
            return $linkOptions;
        },
        'active'=>function (Category $model) {
            return $model->id==Yii::$app->request->get('category_id');
        },
        'options'=>function (Category $model) {
            return ['class'=>['widget'=>'']];
        },
        'dropDownOptions'=>function (Category $model) {
            return [
                'class'=>['widget'=>''],
                'id'=>'cc'.$model->id,
            ];
        },
        'isLeaf'=>function (Category $model) {
            return $model->isLeaf;
        },
    ],
]);
$items=[];
if($results)
    $items = (new MenuTree)->treeMobile($results); //создаем дерево в виде массива
//$items = $items[0]['items']; //убираем корневой элемент
?>
<nav id="category-menu-widget2" class="<?=$this->theme->id=='sakura_light' ? 'nav-gray-category':null ?>" style="display: none;"  >
    <?php
    $this->registerJs("
            var Back_to_all_categories='".Yii::t('db_category', 'Back to all categories')."';
            ", $this::POS_HEAD);
    $items = array_merge([
        [
            'label'=>Yii::t('common', 'Home'),
            'url'=>['/'],
        ],
        [
            'label'=>Yii::t('db_category', 'All categories'),
            'url'=>['/product/product/list'],
        ]
    ],$items);
    echo Nav::widget([
        'id'=>'category-menu-widget2-content',
        'dropDownCaret'=>false,
        'encodeLabels'=>false,
        'options' => ['class' => ['widget'=>'',]],
        'items' => $items,
    ]);
    ?>
</nav>
<div class="navbar <?=$this->theme->id=='sakura' ? 'navbar-inverse':'navbar-default'?> navbar-menu navbar-menu-hidden">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" ><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="javascript:void(0)" class="navbar-brand">
                <?php
                if(isset($this->params['menuTitle']))
                    echo $this->params['menuTitle'];
                ?>
            </a>
        </div>
    </div>
</div>