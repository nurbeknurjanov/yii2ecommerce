<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['region/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('name');?>: <?=$model->name;?></b><br/>
    <b><?=$model->getAttributeLabel('country_id');?>: <?=$model->country_id;?></b><br/>
</div>