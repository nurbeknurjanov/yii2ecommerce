<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use kartik\rating\StarRating;
use extended\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel comment\models\search\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Comments');
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('page');
?>
    <div class="comment-index card">


        <div class="card-header">
            <?= Alert::widget() ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php
            if(Yii::$app->user->can('createComment'))
                echo Html::a(Yii::t('common', 'Create'), ['create'], ['class' => 'btn btn-success']);
            ?>
        </div>

        <?php
        $this->params['columns'] =  $columns = [
            'model_id'=>[
                'attribute'=>'model_id',
                'label'=>'Object',
                'format'=>'raw',
                'value'=>function($data){
                    return Html::a($data->product->title, $data->product->url);
                },
            ],
            //'model_name',
            'rating'=>[
                'attribute'=>'ratingOrderAttribute',
                //'attribute'=>'rating',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->rating ?
                        StarRating::widget([
                            'name' => 'rating-'.$data->id,
                            'value' => $data->rating->mark,
                        ]):null;
                },
            ],
            'name',
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->user ? Html::a($data->user->fullName, ['/user/user/view', 'id'=>$data->user_id]):null;
                },
            ],
            'ip'=>'ip',
            [
                'attribute'=>'text',
                'format'=>'raw',
                'value'=>function($data){
                    return StringHelper::truncate($data->text, 30);
                },
            ],
            'created_at'=>[
                'attribute'=>'created_at',
                'format'=>'datetime',
                'filter'=>$searchModel->getBehavior('dateSearchCreatedAt')->widgetFilter,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'visibleButtons' => [
                    //'view' => true,
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewComment', ['model' => $model]);
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateComment', ['model' => $model]);
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteComment', ['model' => $model]);
                    },
                ],
            ],

        ];
        ?>
        <?php $this->beginBlock('grid') ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $this->params['columns'],
            ]); ?>
        <?php $this->endBlock() ?>
        {{grid}}

    </div>
<?php $this->endBlock() ?>
{{page}}
