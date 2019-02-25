<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;

        /*
        $interval_from = DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'interval_from',
            'dateFormat' => 'yyyy-MM-dd',
            'options'=>array('class'=>'col-lg-6',),
            ]);
        */


        $interval_fromFrom = DateTimePicker::widget([
            'name' => 'interval_fromFrom',
            'value'=>isset($_GET['interval_fromFrom']) ? $_GET['interval_fromFrom']:null,
            //'model' => $searchModel,
            //'attribute' => 'interval_from',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        $interval_fromTo = DateTimePicker::widget([
            'name' => 'interval_fromTo',
            'value'=>isset($_GET['interval_fromTo']) ? $_GET['interval_fromTo']:null,
            //'model' => $searchModel,
            //'attribute' => 'interval_from',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
            ]
        ]);

        /*
        $interval_to = DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'interval_to',
            'dateFormat' => 'yyyy-MM-dd',
            'options'=>array('class'=>'col-lg-6',),
            ]);
        */


        $interval_toFrom = DateTimePicker::widget([
            'name' => 'interval_toFrom',
            'value'=>isset($_GET['interval_toFrom']) ? $_GET['interval_toFrom']:null,
            //'model' => $searchModel,
            //'attribute' => 'interval_to',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        $interval_toTo = DateTimePicker::widget([
            'name' => 'interval_toTo',
            'value'=>isset($_GET['interval_toTo']) ? $_GET['interval_toTo']:null,
            //'model' => $searchModel,
            //'attribute' => 'interval_to',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
            ]
        ]);

/* @var $this yii\web\View */
/* @var $searchModel coupon\models\search\CouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Coupons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createCoupon'))
            echo Html::a(Yii::t('common', 'Create Coupon'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'title',
            'code',
            'discount',
            [
                'attribute'=>'interval_from',
                'format'=>'date',
                'filter'=>$interval_fromFrom.' '.$interval_fromTo,
            ],
            [
                'attribute'=>'interval_to',
                'format'=>'date',
                'filter'=>$interval_toFrom.' '.$interval_toTo,
            ],
            [
                'attribute'=>'used',
                //'format'=>'boolean',
                'value'=>function($data){
                    return $data->usedText;
                },
                'filter'=>$searchModel->usedValues,
            ],
            [
                'attribute'=>'reusable',
                //'format'=>'boolean',
                'value'=>function($data){
                    return $data->reusableText;
                },
                'filter'=>$searchModel->reusableValues,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('viewCoupon', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateCoupon', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('deleteCoupon', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
