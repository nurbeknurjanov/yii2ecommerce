<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model order\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Orders'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('page');
?>
<div class="order-view box">


    <div class="box-header">
        <?php
		if(Yii::$app->user->can('updateOrder', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteOrder', ['model' => $model]))
            echo Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('common', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>

    <?php
    $widget =  Yii::createObject([
        'class'=>DetailView::className(),
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>$model->user ? Html::a($model->user->fullName,
                    ['/user/user/view', 'id'=>$model->user_id]):$model->name,
            ],
            'name',
            'email:email',
            'phone',
            [
                'attribute'=>'country_id',
                'format'=>'raw',
                'value'=>$model->country->name,
            ],
            [
                'attribute'=>'region_id',
                'format'=>'raw',
                'value'=>$model->region->name,
            ],
            [
                'attribute'=>'city_id',
                'format'=>'raw',
                'value'=>$model->city->name,
            ],
            'address',
            'description:ntext',
            [
                'attribute'=>'delivery_id',
                'format'=>'raw',
                'value'=>$model->deliveryText,
            ],
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>'datetime',
            ],
            'amount:currency',
            [
                'attribute'=>'payment_type',
                'value'=>$model->paymentTypeText,
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
        ],
    ]) ;
    $this->params['widget'] = $widget;
    //$widget->attributes['interval_time']='interval_time:boolean';
    $widget->init();
    ?>

    <?php $this->beginBlock('detailView') ?>
        <div class="box-body">
            <?=$widget->run() ?>
            <?=GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels'=>$model->orderProducts,
                    'sort' => [
                        'attributes' =>  [
                            'product_id' => [
                                'asc' => ['product_id' => SORT_ASC,],
                                'desc' => ['product_id' => SORT_DESC,],
                                'default' => SORT_DESC,
                                'label' => 'Name',
                            ],
                        ],
                    ],
                ]),
                'showFooter'=>true,
                'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
                'columns' =>[
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'product_id',
                        //'header'=>'Product',
                        'format'=>'raw',
                        'value'=>function($data) { return Html::a($data->product->title, ['/product/product/view', 'id'=>$data->product_id,]); },
                    ],
                    'count',
                    [
                        'attribute'=>'price',
                        'format'=>'currency',
                    ],
                    [
                        'attribute'=>'amount',
                        'format'=>'currency',
                        'footer' => Yii::$app->formatter->asCurrency($model->amount),
                    ],
                ]
            ]);?>
        </div>
    <?php $this->endBlock() ?>
    {{detailView}}


</div>

<?php

$this->endBlock() ?>
{{page}}
