<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['coupon/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('title');?>: <?=$model->title;?></b><br/>
    <b><?=$model->getAttributeLabel('code');?>: <?=$model->code;?></b><br/>
    <b><?=$model->getAttributeLabel('discount');?>: <?=$model->discount;?></b><br/>
    <b><?=$model->getAttributeLabel('interval_from');?>: <?=$model->interval_from;?></b><br/>
    <b><?=$model->getAttributeLabel('interval_to');?>: <?=$model->interval_to;?></b><br/>
    <b><?=$model->getAttributeLabel('used');?>: <?=$model->used;?></b><br/>
    <b><?=$model->getAttributeLabel('reusable');?>: <?=$model->reusable;?></b><br/>
</div>