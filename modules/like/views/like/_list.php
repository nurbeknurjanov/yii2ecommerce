<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['like/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('model_id');?>: <?=$model->model_id;?></b><br/>
    <b><?=$model->getAttributeLabel('model_name');?>: <?=$model->model_name;?></b><br/>
    <b><?=$model->getAttributeLabel('user_id');?>: <?=$model->user_id;?></b><br/>
    <b><?=$model->getAttributeLabel('ip');?>: <?=$model->ip;?></b><br/>
    <b><?=$model->getAttributeLabel('mark');?>: <?=$model->mark;?></b><br/>
</div>