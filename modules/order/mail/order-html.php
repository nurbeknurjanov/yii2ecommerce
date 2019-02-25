<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $order order\models\Order */
/* @var $model order\models\Order */
/* @var $token user\models\Token */

?>


<div class="row">
    <div class="col-lg-6">
        <h3><?=Yii::t('order', 'Information about order');?></h3>
        <?= DetailView::widget([
            'model' => $model,
            'options'=>['style'=>'border:1px solid #ddd;'],
            'attributes' => [
                [
                    'attribute'=>'id',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'user_id',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$model->user ? $model->user->fullName:$model->name,
                ],
                [
                    'attribute'=>'email',
                    'format'=>'email',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$model->user ? $model->user->email:$model->email,
                ],
                [
                    'attribute'=>'phone',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'address',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$model->country->name.', '.$model->region->name.', '.$model->city->name.': '.$model->address,
                ],
                [
                    'attribute'=>'delivery_id',
                    'format'=>'raw',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                    'value'=>$model->deliveryText,
                ],
                [
                    'attribute'=>'payment_type',
                    'value'=>$model->paymentTypeText,
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'created_at',
                    'format'=>'datetime',
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'status',
                    'value'=>$model->statusText,
                    'captionOptions'=>['style'=>'border:1px solid #ddd;'],
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
            ],
        ]);
        ?>
    </div>
    <div class="col-lg-6">
        <h3><?=Yii::t('order', 'Information about products');?></h3>

        <?php
        echo GridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels'=>$model->orderProducts]),
            'showFooter'=>true,
            'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
            'tableOptions'=>['style'=>'border:1px solid #ddd;'],
            'columns' =>[
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'product_id',
                    'header'=>'Product',
                    'format'=>'raw',
                    'value'=>function($data) { return Html::a($data->product->title, ['/product/product/view', 'id'=>$data->product_id,]); },
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'count',
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
                [
                    'attribute'=>'price',
                    'format'=>'currency',
                    'value'=>function($data) { return $data->price; },
                    'footer' => Yii::$app->formatter->asCurrency($model->amount),
                    'contentOptions'=>['style'=>'border:1px solid #ddd;'],
                ],
            ]
        ]);
        ?>

    </div>
</div>

