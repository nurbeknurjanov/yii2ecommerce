<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use shop\models\Shop;
use file\widgets\file_preview\FilePreview;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use user\models\User;
use category\models\Category;
use extended\view\View;
use product\models\Product;
use extended\helpers\Helper;
use extended\helpers\StringHelper;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \shop\models\Shop */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shops'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <?php
		if(Yii::$app->user->can('updateShop', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteShop', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>


    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            'id',

            'title',
            [
                'attribute'=>'imagesAttribute',
                'format'=>'raw',
                'value'=>FilePreview::widget(['images'=>$model->images]),
                'visible'=>(boolean) $model->images,
            ],
            'description:ntext',
            'address',
                [
                    'attribute'=>'ownerAttribute',
                    'format'=>'raw',
                    'value'=>$model->owner ? $model->owner->link:null,
                ],
                [
                    'attribute'=>'usersAttribute',
                    'format'=>'raw',
                    'value'=>implode(', ', ArrayHelper::map($model->users,'id','link')),
                ],
            ],
        ]) ?>
    </div>
</div>


<div class="product-index card">







    <?php


    $models = $model->products;

    $groups = [];
    ArrayHelper::map($models, 'group_id', function(Product $model) use (&$groups){
        $groups[$model->group_id][$model->id] = $model->id;
    });

    $dataProvider = new \yii\data\ArrayDataProvider([
        'allModels'=>$models,
        'pagination'=>false,
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $index, $widget, $grid) use ($models, $groups, $dataProvider){
            if($dataProvider->sort->attributeOrders)
                return [];
            if($model->group_id && isset($groups[$model->group_id])){
                $group = $groups[$model->group_id];
                $first = current($group);
                $last = end($group);
                if($first==$model->id)
                    return ['style'=>"border-left:2px solid #d2d6de;border-top:2px solid #d2d6de;border-right:2px solid; #d2d6de"];
                elseif($last==$model->id)
                    return ['style'=>"border-left:2px solid #d2d6de;border-bottom:2px solid #d2d6de;border-right:2px solid #d2d6de;"];
                else
                    return ['style'=>"border-left:2px solid #d2d6de;border-right:2px solid #d2d6de;"];
            }
        },
        'columns' => [
            [
                'attribute'=>'id',
                'format'=>'raw',
                'headerOptions'=>[ 'style'=>'width:5px;'],
                'contentOptions'=>[ 'style'=>'width:5px;white-space:normal'],
            ],
            [
                'attribute'=>'imagesAttribute',
                'label'=>Yii::t('common', 'Main Image'),
                'format'=>'raw',
                'value'=>function(Product $data){
                    return $data->mainImage ? $data->mainImage->getThumbImg('xs'):null;
                },
                'filter'=>Helper::$booleanValues,
                'headerOptions'=>[ 'style'=>'width:60px;'],
                'contentOptions'=>[ 'style'=>'width:60px;white-space:normal'],
            ],
            'category_id'=>[
                'attribute'=>'category_id',
                'format'=>'raw',
                'value'=>function(Product $data){
                    return Html::a(StringHelper::truncate($data->category->title, 20),
                        Yii::$app->urlManagerFrontend->createAbsoluteUrl(Url::to($data->category->url)));
                },
                'headerOptions'=>[ 'style'=>'width:60px;'],
                'contentOptions'=>[ 'style'=>'width:60px;white-space:normal'],
            ],
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function(Product $data){
                    return Html::a(StringHelper::truncate($data->title, 20),
                        Yii::$app->urlManagerFrontend->createAbsoluteUrl(Url::to($data->url))) ;
                },

            ],

            'price:currency',
            [
                'attribute'=>'status',
                'value'=>function($data){
                    return $data->statusText;
                },
                'headerOptions'=>[ 'style'=>'width:50px;'],
                'contentOptions'=>[ 'style'=>'width:50px;white-space:normal'],
            ],
            [
                'attribute'=>'dynamicValuesAttribute',
                'format'=>'raw',
                'value'=>function(Product $data){
                    return $data->getValuesText('<br>');
                },
            ],
            'buttons'=>[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}<br>{update}<br>{delete}<br>{copy}<br>{instagram}',
                /*'headerOptions'=>[ 'style'=>'width:20px;'],
                'contentOptions'=>[ 'style'=>'width:20px;white-space:normal'],*/
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-default',
                            'style'=>'margin:2px;',
                        ];
                        if(Yii::$app->user->can('viewProduct', ['model' => $model]))
                            return Html::a('<span class="fa fa-eye"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-primary',
                            'style'=>'margin:2px;',
                        ];
                        if(Yii::$app->user->can('updateProduct', ['model' => $model]))
                            return Html::a('<span class="fa fa-pencil-alt"></span>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-danger',
                            'style'=>'margin:2px;',
                        ];
                        if(Yii::$app->user->can('deleteProduct', ['model' => $model]))
                            return Html::a('<span class="fa fa-times"></span>', $url, $options);
                    },
                    'copy'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Copy'),
                            'aria-label' => Yii::t('yii', 'Copy'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to make a copy of this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class'=>'btn btn-xs btn-primary',
                            'style'=>'margin:2px;',
                        ];
                        if(Yii::$app->user->can('copyProduct', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, $options);
                    },
                    'instagram'=>function ($url, Product $model, $key){
                        $options = [
                            'data-pjax' => '0',
                            'style'=>'margin:2px;',
                        ];
                        $items=[];
                        if($model->productNetworkInstagram)
                            $items[] = [
                                'label'=>'See in instagram',
                                'url'=>'https://www.instagram.com/p/'.$model->productNetworkInstagram->network_code,
                                'linkOptions'=>['target'=>'_blank',],
                            ];
                        if(Yii::$app->user->can('exportInstagram', ['model'=>$model,]))
                            $items[] = [
                                'label'=>'Export to instagram',
                                'url'=>['/product/instagram/export', 'id'=>$model->id],
                            ];
                        if(Yii::$app->user->can('updateInstagram', ['model'=>$model,]))
                            $items[] = [
                                'label'=>'Update images in instagram',
                                'url'=>['/product/instagram/update', 'id'=>$model->id],
                            ];
                        if(Yii::$app->user->can('updateDataInstagram', ['model'=>$model,]))
                            $items[] = [
                                'label'=>'Update description in instagram',
                                'url'=>['/product/instagram/update-data', 'id'=>$model->id],
                            ];
                        if(Yii::$app->user->can('removeInstagram', ['model'=>$model,]))
                            $items[]=[
                                'label'=>'Remove from instagram',
                                'url'=>['/product/instagram/remove', 'id'=>$model->id],
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('product', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ];

                        $items[]=[
                            'label'=>'Soon Facebook, Amazon, Ebay integration',
                            'url'=>'javascript:void(0)',
                            'role' => 'presentation',
                            'class' => 'divider'
                        ];

                        return  ButtonDropdown::widget([
                            'encodeLabel'=>false,
                            'label' => '<span class="fa fa-instagram"></span>',
                            'dropdown' => [
                                'items' => $items,
                                'options' => [
                                    'class'=>'dropdown-menu-right',
                                    //'style' => 'min-width:auto'
                                ],
                            ],
                            'options' => [
                                'class' => 'btn btn-xs '.($model->productNetworkInstagram ? 'btn-primary':'')
                            ],
                        ]);
                    },

                ],
            ],
        ],
    ]);

    ?>


</div>