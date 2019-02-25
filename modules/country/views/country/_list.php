<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['country/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('short_name');?>: <?=$model->short_name;?></b><br/>
    <b><?=$model->getAttributeLabel('name');?>: <?=$model->name;?></b><br/>
</div>