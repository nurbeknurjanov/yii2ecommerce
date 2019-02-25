<?php
use yii\helpers\Html;
?>
<div class="col-lg-6">
    <b><?=Html::a($model->title, ['category/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('tree');?>: <?=$model->tree;?></b><br/>
    <b><?=$model->getAttributeLabel('lft');?>: <?=$model->lft;?></b><br/>
    <b><?=$model->getAttributeLabel('rgt');?>: <?=$model->rgt;?></b><br/>
    <b><?=$model->getAttributeLabel('depth');?>: <?=$model->depth;?></b><br/>
    <b><?=$model->getAttributeLabel('title');?>: <?=$model->title;?></b><br/>
</div>