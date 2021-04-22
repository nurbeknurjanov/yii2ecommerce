<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model article\models\Article */


$this->title = $model->title;


$this->params['breadcrumbs'][] = ['label' => $model->typeText, 'url' => ['/article/article/list', 'ArticleSearch[type]'=>$model->type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <span class="date"><?=Yii::$app->formatter->asDatetime($model->created_at);?></span>

    <p>
        <?=$model->text;?>
    </p>

    <div class="view-image">
        <?php
        if($video = $model->video){
            ?>
            <?=$model->video->img?>
            <?php
        }
        ?>
        <?php
        $images = $model->images;
        foreach ($images as $index=>$image){
            ?>
            <a href="<?=$image->imageUrl;?>"  class="image-<?=$index;?>" id="lightbox-<?=$image->id;?>" data-lightbox="roadtrip"  >
                <?=Html::img($image->getThumbUrl("md"));?>
            </a>
            <?php
        }
        ?>
    </div>


    <p class="tags">
        <?=$model->tagsText;?>
    </p>

</div>
