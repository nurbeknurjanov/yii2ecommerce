<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model page\models\Page */

$this->title = $model->title;

$this->params['breadcrumbs'][] = $this->title;
$this->params['topTitle'] = $this->title;
?>
<div class="page-view">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?=$model->text;?>
    </p>
    <div class="">
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


</div>
