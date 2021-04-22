<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use country\models\City;

/* @var $this yii\web\View */
/* @var $searchModel country\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::$container->set(\yii\widgets\LinkPager::class,[
    'firstPageLabel' => true,
    'lastPageLabel' => true,
]);

$this->title = Yii::t('country', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index card">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="card-header">
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createCity'))
            echo Html::a(Yii::t('country', 'Create City'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute'=>'region_id',
                'format'=>'raw',
                'value'=>function(City $data){
                    return $data->region->name;
                },
            ],
            [
                'attribute'=>'country_id',
                'format'=>'raw',
                'value'=>function(City $data){
                    return $data->region->country->name;
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
                        if(Yii::$app->user->can('viewCity', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateCity', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteCity', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
