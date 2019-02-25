<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use tag\models\Tag;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel article\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index box">


    <div class="box-header">
        <?= Alert::widget() ?>

        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


        <?php
        if(Yii::$app->user->can('createArticle'))
            echo Html::a(Yii::t('article', 'Create article'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'type',
                'value'=>function($data){
                    return $data->typeText;
                },
                'filter'=>$searchModel->typeValues,
            ],
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->title, 30);
                },
            ],
            [
                'attribute'=>'text',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->title, 30);
                },
            ],
            'created_at'=>[
                'attribute'=>'created_at',
                'format'=>'datetime',
                'filter'=>$searchModel->getBehavior('dateSearchCreatedAt')->widgetFilter,
            ],
            [
                'attribute'=>'tagsAttribute',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->tagsText;
                },
                'filter'=>ArrayHelper::map(Tag::find()->all(), 'id', 'title'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'visibleButtons' => [
                    //'view' => true,
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewArticle', ['model' => $model]);
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateArticle', ['model' => $model]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteArticle', ['model' => $model]);
                    },
                ],
            ],

        ],
    ]); ?>

</div>