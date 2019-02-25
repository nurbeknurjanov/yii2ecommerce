<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
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

/* @var $this yii\web\View */
/* @var $searchModel \product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('product', 'Products');
$this->params['breadcrumbs'][] = $this->title;


$this->beginBlock('page');
?>
<div class="product-index box">



    <div class="box-header">
        <?= Alert::widget() ?>
        <?=$this->render('_search', ['model' => $searchModel,]); ?>

        <?php
		if(Yii::$app->user->can('createProduct'))
            echo Html::a(Yii::t('product', 'Create Product'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>



    <?php
    $columns = [
        [
            'class'=>'yii\grid\CheckboxColumn',
            //'name'=>'selection',
            //'header'=>'Check',
            //'multiple'=>true,
            /*  'checkboxOptions' => function(Student $model, $key, $index, $column) {
                  return [
                      'value' => $model->id,
                      //'checked' => true,
                  ];
              }*/
        ],
        [
            'attribute'=>'id',
            'format'=>'raw',
            'headerOptions'=>[ 'style'=>'width:10px;'],
            'contentOptions'=>[ 'style'=>'width:10px;white-space:normal'],
            'value'=>function(Product $data){
                return Html::a($data->id, $data->url);
            },
        ],
        [
            'attribute'=>'imagesAttribute',
            'label'=>'Main image',
            'format'=>'raw',
            'value'=>function(Product $data){
                return $data->mainImage ? $data->mainImage->img:null;
            },
            'filter'=>Helper::$booleanValues,
        ],
        'category_id'=>[
            'attribute'=>'category_id',
            'format'=>'raw',
            'value'=>function(Product $data){
                return $data->category ? $data->category->title : null;
            },
            'headerOptions'=>[ 'style'=>'width:60px;'],
            'contentOptions'=>[ 'style'=>'width:60px;white-space:normal'],
            'filter'=>Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map(
                    Category::find()
                        ->defaultFrom()->defaultOrder()
                        ->selectTitle()->enabled()->all(), 'id', 'title'), ['prompt'=>'Select', 'encode'=>false, 'class'=>'form-control',]),
        ],
        [
            'attribute'=>'title',
            'format'=>'raw',
            'value'=>function($data){
                return Html::a(StringHelper::truncate($data->title, 20), $data->url) ;
            },
        ],
        'sku'=>[
            'attribute'=>'sku',
            'headerOptions'=>[ 'style'=>'width:20px;'],
            'contentOptions'=>[ 'style'=>'width:20px;white-space:normal'],
        ],
        'type'=>[
            'attribute'=>'type',
            'format'=>'raw',
            'value'=>function($data){
                return $data->typeText;
            },
            'headerOptions'=>[ 'style'=>'width:50px;'],
            'contentOptions'=>[ 'style'=>'width:50px;white-space:normal'],
            'filter'=>$searchModel->typeValues,
        ],
        'price:currency',
        [
            'attribute'=>'status',
            'value'=>function($data){
                return $data->statusText;
            },
            'headerOptions'=>[ 'style'=>'width:50px;'],
            'contentOptions'=>[ 'style'=>'width:50px;white-space:normal'],
            'filter'=>$searchModel->statusValues,
        ],
        [
            'attribute'=>'dynamicValuesAttribute',
            'label'=>'Characteristics',
            'format'=>'raw',
            'headerOptions'=>[ 'style'=>'width:50px;'],
            'contentOptions'=>[ 'style'=>'width:50px;white-space:normal'],
            'value'=>function(Product $data){
                return $data->getValuesText('<br>');
            },
            'filter'=>Helper::$booleanValues,
        ],
        'buttons'=>[
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{view} {update} {delete} {copy} {instagram}',
            /*'headerOptions'=>[ 'style'=>'width:20px;'],
            'contentOptions'=>[ 'style'=>'width:20px;white-space:normal'],*/
            'buttons'=>[
                'view'=>function ($url, $model, $key){
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                        'class'=>'btn btn-xs btn-default',
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
                    ];
                    if(Yii::$app->user->can('updateProduct', ['model' => $model]))
                        return Html::a('<span class="fa fa-pencil"></span>', $url, $options);
                },
                'delete'=>function ($url, $model, $key){
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class'=>'btn btn-xs btn-danger',
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
                    ];
                    if(Yii::$app->user->can('copyProduct', ['model' => $model]))
                        return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, $options);
                },
                'instagram'=>function ($url, Product $model, $key){
                    $options = [
                        'data-pjax' => '0',
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
    ];



    $models = $dataProvider->models;

    $groups = [];
     ArrayHelper::map($models, 'group_id', function(Product $model) use (&$groups){
        $groups[$model->group_id][$model->id] = $model->id;
    });

    $widget = Yii::createObject([
        'class'=>GridView::class,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid) use ($models, $groups, $dataProvider){
            if($dataProvider->sort->attributeOrders)
                return [];
            if($model->group_id && isset($groups[$model->group_id])){
                $group = $groups[$model->group_id];
                $first = current($group);
                $last = end($group);
                if($first==$model->id)
                    return ['style'=>"border-left:2px solid;border-top:2px solid;border-right:2px solid;"];
                elseif($last==$model->id)
                    return ['style'=>"border-left:2px solid;border-bottom:2px solid;border-right:2px solid;"];
                else
                    return ['style'=>"border-left:2px solid;border-right:2px solid;"];
            }
        },
        'columns' => $columns,
    ]);

    $this->params['widget'] = $widget;
    $this->params['columns'] = $columns;
    $widget->columns=$columns;
    $widget->init();
    $this->beginBlock('grid');
        $widget->run();
    $this->endBlock();
?>
    {{grid}}

    <div id="multipleForm" style="display: none"  >
        With checked:
        <?=$this->render('_multiple_form');  ?>
    </div>

</div>
<?php
$this->endBlock();
?>
{{page}}
