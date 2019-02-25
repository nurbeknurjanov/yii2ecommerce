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
$this->context->layout ='/product/main_products';
$viewStyle = Yii::$app->response->cookies->get('viewStyle')?:Yii::$app->request->cookies->get('viewStyle');

$this->render('_title_and_breadcrums',
    ['title'=>$title, 'searchModel'=>$searchModel, 'dataProvider'=>$dataProvider,]);
$this->params['title'] = $this->title.' - '.Yii::$app->name;
if(Yii::$app->request->isPjax)
    $this->title = $this->params['title'];
$this->params['description'] = $this->title;
?>

<?php

/*(new \kartik\base\Widget(['pjaxContainerId'=>'productsPjax']))->registerWidgetJs("
alert('Hey');
");*/

Pjax::begin([
    'id'=>'productsPjax',
    'linkSelector'=>'.list-view-top a',
    //'formSelector'=>'#leftSearchForm',
    'timeout'=>6000,
]);
?>

<?= Alert::widget() ?>
<?php
if(!$searchModel->category_id || $searchModel->category->isLeaf){
    if(Yii::$app->request->get('q')){
        ?>
        <h1><?= $this->params['titleH1'] ?></h1>
        <?php
    }else{
        ?>
        <h1 class="title"><?= $this->title ?></h1>
        <?php
    }
}
?>
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