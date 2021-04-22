<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use category\models\Category;
use yii\helpers\Url;
use nirvana\infinitescroll\InfiniteScrollPager;
use yii\grid\GridViewAsset;

/* @var $this yii\web\View */
/* @var $searchModel product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */





GridViewAsset::register($this);

$this->context->layout ='main';
if($this->theme->id=='bootstrap')
    $this->context->layout ='/product/main_products';

$viewStyle = Yii::$app->response->cookies->get('viewStyle')?:Yii::$app->request->cookies->get('viewStyle');


$this->params['searchModel'] = $searchModel;
$this->params['category'] = $category = $searchModel->category;

$this->title = $title;
$this->params['description'] = $this->title;
if(Yii::$app->request->isPjax)
    $this->title = $this->title.' | '.Yii::$app->name;

$this->params['fullPageSearchTitle'] = $fullPageSearchTitle;
$this->params['fullPageCategoryTitle'] = $fullPageCategoryTitle;
$this->params['topTitle'] = $topTitle;
$this->params['menuTitle'] = $menuTitle;

/*(new \kartik\base\Widget(['pjaxContainerId'=>'productsPjax']))->registerWidgetJs("
    ");*/


if($category) {
    $this->params['breadcrumbs'][] =
        [
            'label' => Yii::t('product', 'All products'),
            'url' => ['/product/product/list']
        ];
    foreach ($category->parents()->all() as $parent)
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => $parent->url];
}

$this->params['breadcrumbs'][] = $breadCrumbTitle;


Pjax::begin([
    'id'=>'productsPjax',
    'linkSelector'=>'.list-view-top a',
    //'formSelector'=>'#leftSearchForm',
    'timeout'=>6000,
]);


?>

<?= Alert::widget() ?>

<h1 class="title"><?= $pageTitle ?></h1>
<?=$this->render('_gridview_top_links', ['dataProvider' => $dataProvider, 'viewStyle'=>$viewStyle])?>
<?= ListView::widget([
    'id'=>'listView',
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) use ($viewStyle) {
        if($viewStyle && $viewStyle->value=='asList')
            return $this->render('_list/_list_as_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
        return $this->render('_list/_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
    },
    'layout' => "<div class=\"items\">{items}</div>\n<div class='clear'></div>{pager}",
    'pager' => [
        'class' => InfiniteScrollPager::class,
        'widgetId' => 'listView',
        'itemsCssClass' => 'items',
        'contentLoadedCallback' => 'function(data){
            $(\'.product-rating-class\').rating({"showClear":false,"size":"xs","step":1,"showCaption":false,"displayOnly":true,"language":"ru"});
         }',
        'options'=>[
            'class'=>'paginationOther',
            'style'=>'padding:0;',
        ],
        'nextPageLabel' => Yii::t('common', 'Load more'),
        'linkOptions' => [
            'class' => 'btn btn-primary',//btn-block
        ],
        'pluginOptions' => [
            'loading' => [
                'msgText' => "<em>Loading next set of items...</em>",
                'finishedMsg' => "<em>No more items to load</em>",
            ],
            'behavior' => InfiniteScrollPager::BEHAVIOR_TWITTER,
        ],
    ],
]) ?>
<?php
/*$this->registerJs("
$(window).scroll(function() {

    if (($(window).innerHeight() + $(window).scrollTop()) >= $('body').height())
    {
            $('#listView .items').infinitescroll('scroll');
    }
});
");*/

Pjax::end();
?>