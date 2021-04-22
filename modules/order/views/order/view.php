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

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('order', 'My orders'), 'url' => ['/order/order/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>



    <div class="row">
        <div class="col-lg-6">
            <h3><?=Yii::t('order', 'Information about order');?></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    [
                        'attribute'=>'user_id',
                        'format'=>'raw',
                        'value'=>$model->user ? Html::a($model->user->fullName,
                            ['/user/user/view', 'id'=>$model->user_id]):$model->name,
                    ],
                    [
                        'attribute'=>'email',
                        'format'=>'email',
                        'value'=>$model->user ? $model->user->email:$model->email,
                    ],
                    'phone',
                    [
                        'attribute'=>'address',
                        'format'=>'raw',
                        'value'=>implode(', ',
                            [$model->country->name, $model->region->name, $model->city->name,  $model->address]),
                    ],
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
                        'attribute'=>'payment_type',
                        'value'=>$model->paymentTypeText,
                    ],
                    [
                        'attribute'=>'status',
                        'value'=>$model->statusText,
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <h3><?=Yii::t('order', 'Information about products');?></h3>
            <?=GridView::widget([
                'summary'=>false,
                'dataProvider' => new \yii\data\ArrayDataProvider(['allModels'=>$model->orderProducts]),
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
            ]); ?>
        </div>
    </div>

</div>
