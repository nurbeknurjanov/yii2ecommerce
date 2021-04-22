<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use eav\models\DynamicValue;
use file\widgets\file_preview\FilePreview;
use product\models\Product;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \product\models\Product */

$this->registerLinkTag(['rel' => 'canonical',  'href' => Url::to($model->url)]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('product', 'Products'), 'url' => [Yii::$app->controller->defaultAction]];

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-view card">


    <div class="card-header">
        <div style="float: left;">
            <?php
            if(Yii::$app->user->can('updateProduct', ['model' => $model]))
                echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            ?>
            <?php
            if(Yii::$app->user->can('deleteProduct', ['model' => $model]))
                echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('product', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
            ?>
        </div>

        <div style="float: right;">
            <?php
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

            echo ButtonDropdown::widget([
                'encodeLabel'=>false,
                'label' => 'Instagram',
                'dropdown' => [
                    'items' => $items,
                    'options' => [
                        'class'=>'dropdown-menu-right',
                        //'style' => 'min-width:auto'
                    ],
                ],
                'options' => [
                    'class' => 'btn '.($model->productNetworkInstagram ? 'btn-primary':'')
                ],
            ]);
            ?>
        </div>
    </div>


    <?php
    $fields=[];
    foreach ($model->getValues()->with('field')->all() as $valueModel)
        $fields[]=[
            'attribute'=>'id',
            'label'=>$valueModel->field->label,
            'format'=>'raw',
            'value'=>$valueModel->valueText.$valueModel->field->unit,
        ];
    $fieldsDetailView = DetailView::widget([
        'model' => $model,
        'attributes' => $fields,
    ]);
    ?>

    <?php $widget =  Yii::createObject([
        'class'=>DetailView::class,
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'category_id'=>[
                'attribute'=>'category_id',
                'format'=>'raw',
                'value'=>$model->category ? $model->category->title:null,
            ],
            'sku'=>'sku',
            'price:currency',
            'description:raw',
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
            [
                'attribute'=>'discount',
                'value'=>$model->discountText,
            ],
            [
                'attribute'=>'imagesAttribute',
                'label'=>Yii::t('common', 'Main Image'),
                'format'=>'raw',
                'value'=>$model->getImages()->queryMainImage()->one()
                    ?
                    FilePreview::widget(['image'=>$model->getImages()->queryMainImage()->one(), 'actions'=>false])
                    : null,
            ],
            [
                'attribute'=>'imagesAttribute',
                'format'=>'raw',
                'value'=>FilePreview::widget(['images'=>$model->images, 'actions'=>false]),
            ],
            [
                'attribute'=>'buyWithThisAttribute',
                'format'=>'raw',
                'value'=>call_user_func(function() use($model) {
                    $products = ArrayHelper::map($model->buyProducts, 'id', function(Product $product){
                        return Html::a($product->title, $product->url);
                    });
                    return implode('<br>', $products);
                }),
            ],
            [
                'attribute'=>'id',
                'label'=> 'Grouped products',
                'format'=>'raw',
                'value'=>call_user_func(function() use($model) {
                    $products = ArrayHelper::map($model->groups, 'id', function(Product $product){
                        return Html::a($product->title, $product->url);
                    });
                    return implode('<br>', $products);
                }),
                'visible'=>$model->isGrouped,
            ],
            [
                'attribute'=>'id',
                'label'=>Yii::t('product', 'Characteristics'),
                'format'=>'raw',
                'value'=>$fieldsDetailView,
            ],
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>$model->user ? $model->user->name:null,
            ],
            'enabled:boolean',
        ]
    ]) ;
    $this->params['widget'] = $widget;
    //$widget->attributes['someKey']='someAttribute:raw';
    $widget->init();
    ?>

    <?php
    $this->beginBlock('detailView');
    ?>
    <div class="card-body">
        <?=$widget->run();?>
    </div>
    <?php
    $this->endBlock();
    ?>
    {{detailView}}

</div>