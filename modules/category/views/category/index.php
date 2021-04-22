<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use category\models\Category;
use \yii\grid\GridViewAsset;
use extended\helpers\StringHelper;
use extended\helpers\Helper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \category\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

GridViewAsset::register($this);

$this->title = Yii::t('category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;



?>

<?= Alert::widget() ?>


<div class="category-index card">


    <div class="card-header">

        <?=$this->render('_search', ['model' => $searchModel]); ?>
        <?php
        if(Yii::$app->user->can('createCategory'))
            echo Html::a(Yii::t('category', 'Create Category'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php
    $dataProvider->pagination = false;

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'contentOptions'=>['style'=>'width:10px;',],
            ],
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>function(Category $data){
                    /*$image = $data->getThumbImg('xs');
                    $image = str_replace("nbsp;",'', $image);
                    return str_replace("&amp;",'', $image);*/
                    return $data->image ? $data->image->imageImg:null;
                },
                'filter'=>Helper::$booleanValues,
            ],
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function(Category $data){
                    return $data->title;
                },
            ],
            //'title_ru',
            [
                'attribute'=>'title_url',
                'format'=>'raw',
                'value'=>function(Category $data){
                    return Html::a(StringHelper::truncate($data->title_url, 20),
                        Yii::$app->urlManagerFrontend->createAbsoluteUrl(Url::to($data->url))) ;
                },
            ],
            [
                'attribute'=>'text',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->text, 10) ;
                },
            ],
            [
                'attribute'=>'enabled',
                'format'=>'boolean',
                'contentOptions'=>['style'=>'width:10px;',],
            ],
            'buttons'=>[
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    //'view' => true,
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewCategory', ['model' => $model]);
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateCategory', ['model' => $model]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteCategory', ['model' => $model]);
                    },
                ],
            ],
        ],
    ]);

    ?>


</div>
