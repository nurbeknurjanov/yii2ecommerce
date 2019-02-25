<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


use yii\widgets\ListView;
use yii\widgets\Pjax;
use richardfan\widget\JSRegister;
use yii\data\ActiveDataProvider;
use product\models\query\RatingQuery;

$query = $model->getComments();
$query->joinWith(['rating'=>function(RatingQuery $leftQuery){
    $leftQuery->defaultFrom();
}]);

$query->with('likes');
$dataProvider = new ActiveDataProvider([
    'query'=>$query,
]);
$dataProvider->sort = [
    'defaultOrder' => ['ratingOrderAttribute'=>SORT_DESC],
    'attributes'=>[
        'ratingOrderAttribute' => [
            'label' => Yii::t('product-sort', 'rating'),
            'desc' => ['rating.mark' => SORT_DESC],
            'asc' => ['rating.mark'=> SORT_ASC],
        ],
        'created_at' => [
            'label' => Yii::t('product-sort', 'сreated date'),
        ],
    ]
];
$pagination = $dataProvider->pagination;
$pagination->pageSize = 3;
//$pagination->pageParam = "commentPage";
//$pagination->pageSizeParam = "commentPerPage";
$pagination->totalCount = $dataProvider->query->count();
//$pagination->page = ceil($pagination->totalCount/$pagination->pageSize)-1;//page свойство всегда на минус один
?>

<?php Pjax::begin(['id' => 'commentsPjax', 'enablePushState'=>true,]) ?>
    <div class="sort-comment sort-ordinal">
        <?=Yii::t('product', 'Sort by');?>:
        <?=$dataProvider->sort->link('created_at');?>,
        <?=$dataProvider->sort->link('ratingOrderAttribute');?>
    </div>
    <?= ListView::widget([
        'summary'=>false,
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('@comment/views/comment/frontend/list/_list/_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
        },
    ]) ?>
<?php Pjax::end() ?>



<?php JSRegister::begin(); ?>
    <script>
        $('#commentsPjax').on('pjax:end', function() {
            $.pjax.reload({container:'#commentCountPjax'});
        });
        $('#commentCountPjax').on('pjax:end', function() {
            $.pjax.reload({container:'#starPjax', });
        });
        /*$('#commentsPjax, #commentCountPjax, #starPjax').on('pjax:error', function() {
            return false;
        });*/
    </script>
<?php JSRegister::end(); ?>

<?php

if(Yii::$app->user->can('createComment', ['object'=>$model])){
    echo $this->render("@comment/views/comment/frontend/create/_create_comment_for_product", ['object'=>$model,
        'pagination'=>$pagination, 'dataProvider'=>$dataProvider]);

    // $pagination->totalCount+1 потому что новый добавится, подготовка к следующему
    $page = ceil(($pagination->totalCount+1)/$pagination->pageSize);
    $this->registerJs(
        "
        $('#newCommentPjax').on('pjax:end', function() {
            var u = new Url();
            u.query['{$pagination->pageParam}']=$page;
            u.query['{$pagination->pageSizeParam}']=$pagination->pageSize;
            u.query.{$dataProvider->sort->sortParam}='created_at';
            $.pjax.reload('#commentsPjax', {url:u.toString()});  
        });
         
    "
    );
}



