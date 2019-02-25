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
            $linkOptions=[];
            if($model->depth==1)
                $linkOptions['class'] = ['widget'=>'bold'];
            return $linkOptions;
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
    'brandLabel' => false,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-inverse navbar-menu',
    ],
]);
echo Nav::widget([
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
            return ['class'=>['widget'=>'']];
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
<nav id="category-menu" style="display: none;" >
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
        'dropDownCaret'=>false,
        'encodeLabels'=>false,
        'options' => ['class' => ['widget'=>'',]],
        'items' => $items,
    ]);
    ?>
</nav>
<div class="navbar navbar-inverse navbar-menu navbar-menu-hidden">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w29-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            if(Yii::$app->controller->route=='product/product/list'){
                if(isset($this->params['category']))
                    echo Html::a($this->params['category']->title, $this->params['category']->url, ['class'=>'navbar-brand']);
                else
                    echo Html::a(Yii::t('product', 'All products'), ['/product/product/list'], ['class'=>'navbar-brand']);
            }
            if(Yii::$app->controller->route=='product/product/view'){
                if(isset($this->params['product']))
                    echo Html::a($this->params['product']->title, $this->params['product']->url, ['class'=>'navbar-brand']);
            }
            ?>
        </div>
    </div>
</div>


