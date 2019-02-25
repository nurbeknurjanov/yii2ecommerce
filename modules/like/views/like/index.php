<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use yii\helpers\StringHelper;
use like\models\Like;
use extended\helpers\Helper;

/* @var $this yii\web\View */
/* @var $searchModel \like\models\search\LikeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Likes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-index box">


    <div class="box-header">
        <?= Alert::widget() ?>
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'model_id',
                'label'=>'Object',
                'format'=>'raw',
                'value'=>function(Like $data){
                    $objectID = Helper::getId($data->model_name);
                    return Html::a(StringHelper::truncate(strip_tags($data->object->text), 20),
                        ["/$objectID/$objectID/view", 'id'=>$data->model_id]);
                },
            ],
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->user ? Html::a($data->user->fullName, ['/user/user/view', 'id'=>$data->user_id]):null;
                },
            ],
            'ip',
            [
                'attribute'=>'mark',
                'value'=>function($data){
                    return $data->markText;
                },
                'filter'=>$searchModel->markValues,
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
                        if(Yii::$app->user->can('viewLike', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateLike', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteLike', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
