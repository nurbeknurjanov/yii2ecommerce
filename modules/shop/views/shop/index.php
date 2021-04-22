<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use shop\models\Shop;
use extended\helpers\Helper;

/* @var $this yii\web\View */
/* @var $searchModel \shop\models\search\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shops');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Alert::widget() ?>


    <div class="card-header">
        <?php
		if(Yii::$app->user->can('createShop'))
            echo Html::a(Yii::t('app', 'Create shop'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function(Shop $data){
                    return Html::a($data->title, $data->url);
                },
            ],
            [
                'attribute'=>'imagesAttribute',
                'label'=>'Image',
                'format'=>'raw',
                'value'=>function(Shop $data){
                    return $data->getThumbImg('xs');
                },
                'filter'=>Helper::$booleanValues,
            ],
            'description:ntext',
            'address',
            [
                'attribute'=>'ownerAttribute',
                'format'=>'raw',
                'value'=>function(Shop $data){
                    if($data->owner)
                        return $data->owner->link;
                },
            ],
            [
                'attribute'=>'usersAttribute',
                'format'=>'raw',
                'value'=>function(Shop $data){
                    return implode(', ', ArrayHelper::map($data->users,'id','link'));
                },
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
                        if(Yii::$app->user->can('viewShop', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateShop', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteShop', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
