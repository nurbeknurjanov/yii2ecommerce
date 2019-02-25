<?php
use yii\helpers\Html;
use extended\helpers\StringHelper;
?>
<div class="col-lg-6 article-list" >
    <?php
    if($model->video){
        ?>
        <div class="article-image">
            <?=$model->video->img?>
        </div>
        <?php
    }elseif($model->mainImage){
        ?>
        <div class="article-image" >
            <?=$model->mainImage->img;?>
        </div>
        <?php
    }
    ?>
    <div class="article-list-block" >
        <?=Html::a(StringHelper::truncate($model->title, 65), ['/article/article/view', 'id'=>$model->id,]);?>
        <div class="date"><?=Yii::$app->formatter->asDatetime($model->created_at, 'short');?></div>
        <p>
            <?=StringHelper::truncate($model->text, 140);?>
        </p>
    </div>
</div>