<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use yii\grid\GridView;
use order\models\OrderProduct;
use yii\data\ArrayDataProvider;

/* @var \order\models\Order $model */
/* @var ActiveForm $form */

?>

<?=GridView::widget([
    'id'=>'orderProductsGrid',
    'dataProvider' => new ArrayDataProvider(['allModels'=>$model->basketProducts]),
    'summary'=>false,
    'showFooter'=>true,
    'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
    'columns' =>[
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'product_id',
            'format'=>'raw',
            'value'=>function($data) { return Html::a($data->product->title, ['/product/product/view', 'id'=>$data->product_id,]); },
        ],
        [
            'attribute'=>'count',
            'format'=>'raw',
            'value'=>function($data) use ($form) {
                ob_start();
                ?>
                <?=$form->field($data, "[$data->product_id]count")->begin(); ?>
                <?=Html::activeTextInput($data, "[$data->product_id]count", ['style'=>'max-width:80px;', 'class'=>'count form-control',]) ?>
                <?= Html::error($data, "[$data->product_id]count", ['class'=>'help-block']) ?>
                <?=$form->field($data, "[$data->product_id]count")->end(); ?>
                <?php
                $content = ob_get_contents();
                ob_end_clean();
                return $content;
            },
            'contentOptions' =>function ($model, $key, $index, $column){
                return ['class' => 'countTD'];
            },
        ],
        [
            'attribute'=>'price',
            'format'=>'currency',
            'contentOptions' =>function ($model, $key, $index, $column){
                return [
                    'class' => 'priceTD',
                    'data-price' => $model->price,
                    'data-currency' => Yii::$app->formatter->currencySymbol,
                ];
            },
        ],
        [
            'label'=>Yii::t('order', 'Amount'),
            'format'=>'currency',
            'value'=>function(OrderProduct $data){
                return $data->amount;
            },
            'footer' => Yii::$app->formatter->asCurrency($model->amount),
            'contentOptions' =>function (OrderProduct $data, $key, $index, $column){
                return [
                    'class' => 'amountTD',
                    'data-amount' => $data->amount,
                ];
            },
            'footerOptions' => ['class' => 'totalAmountTD'],
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
            'buttons'=>[
                'delete'=>function ($url, $model, $key){
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data' =>[
                            'form'=>'anotherForm',
                            'confirm'=>Yii::t('common', 'Are you sure you want to delete this item from shopping cart ?')
                        ]
                    ];
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        ['/order/order-product/delete', 'product_id'=>$model->product_id,], $options);
                },
            ],
        ]
    ]
]); ?>