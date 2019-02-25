<?php
use extended\helpers\Html;
use kartik\rating\StarRating;
use comment\models\Comment;
use extended\helpers\Helper;
use extended\helpers\ArrayHelper;
use like\models\Like;

/* @var $this yii\web\View */
/* @var $model \comment\models\Comment */
?>
<div class="comment-list">
    <div>
        <div class="rating-block pull-left">
            <?=StarRating::widget([
                'id' => 'comment-rating-'.$model->id,
                'name' => 'comment-rating-'.$model->id,
                'value' => $model->rating ? $model->rating->mark:0,
            ]);?>
        </div>
        <div class="name pull-left">
            <?=$model->nameAttributeText;?>
        </div>
        <div class="date pull-right"><?=Yii::$app->formatter->asDatetime($model->created_at, 'short');?></div>
    </div>
    <div class="clear"></div>
    <div>
        <?=$model->text;?>
    </div>
    <div class="list-image">
        <?php
        if($model->video)
            echo $model->video->img;

        if($images = $model->images){
            $items = [];
            foreach ($images as $image)
                $items[] = [
                    'content'=>Html::a(Html::img($image->getThumbUrl("sm")), $image->imageUrl, ['data-lightbox'=>'road-'.$model->id] ),
                ];
            ?>
            <div>
                <?=\yii\bootstrap\Carousel::widget([
                    'id'=>'carousel-'.$model->id,
                    'showIndicators'=>false,
                    'items' => $items,
                    'options' => [
                        'class' => 'carousel slide',
                        'data-interval' => '6000'
                    ],
                ])?>
            </div>
            <?php
        }
        ?>
    </div>
    <div style="text-align: right">
        <?php
        $canCreateLike = Yii::$app->user->can('createLike', ['object'=>$model]);

        //factor +
        echo Html::a(Html::i(['class'=>'glyphicon glyphicon-thumbs-up']),
                ['/like/like/create', 'model_name'=>$model::className(), 'model_id'=>$model->id, 'mark'=>1], [
            'class'=>'hoverGreen like '.(!$canCreateLike ? 'disabledLike':null),
            'data-mark'=>1,
            'data-model_name'=>$model::className(),
            'data-model_id'=>$model->id]);

        //factor result
        $rating = $model->rating;
        $plusLike=0;
        $minusLike=0;
        ArrayHelper::map($model->likes, 'id', function(Like $like) use (&$plusLike, &$minusLike){
            if($like->mark==1)
                $plusLike++;
            if($like->mark==-1)
                $minusLike++;
        });
        $title = '+'.$plusLike.'/-'.$minusLike;
        $ratingFactorOptions=['class'=>'ratingFactorResult' ,'title'=>$title];
        if($rating->factor>0)
            Html::addCssClass($ratingFactorOptions, 'green');
        if($rating->factor==0)
            Html::addCssClass($ratingFactorOptions, 'gray');
        if($rating->factor<0)
            Html::addCssClass($ratingFactorOptions, 'red');
        echo Html::tag('span', $rating->factor, $ratingFactorOptions);

        //factor -
        echo Html::a(Html::i(['class'=>'glyphicon glyphicon-thumbs-down']),
            ['/like/like/create', 'model_name'=>$model::className(), 'model_id'=>$model->id, 'mark'=>-1],  [
                'class'=>'hoverRed like '.(!$canCreateLike ? 'disabledLike':null),
                'data-mark'=>-1,
                'data-model_name'=>$model::className(),
                'data-model_id'=>$model->id]);
        ?>
        <br/>
        <?php
        if(Yii::$app->user->can('deleteComment', ['model'=>$model]))
            echo Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['/comment/comment/delete', 'id'=>$model->id],  [
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => 1,
                    'class' => 'red commentRemove',
                    //'data-ajax' => '1',//just for ajax
                ]);?>
    </div>

</div>