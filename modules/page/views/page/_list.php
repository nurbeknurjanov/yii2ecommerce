<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['page/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('title_url');?>: <?=$model->title_url;?></b><br/>
    <b><?=$model->getAttributeLabel('title');?>: <?=$model->title;?></b><br/>
    <b><?=$model->getAttributeLabel('text');?>: <?=$model->text;?></b><br/>
</div>