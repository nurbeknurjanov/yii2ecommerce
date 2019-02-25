<?php
use yii\helpers\Html;
/* @var $model \user\models\User */
?>
<div class="well">
    <?=$model->getAttributeLabel('id');?>:<?=Html::a($model->id, ['/user/user/view', 'id'=>$model->id,]);?><br/>
    <?=$model->getAttributeLabel('name');?>:<?=$model->name;?><br/>
    <?=$model->getAttributeLabel('username');?>:<?=$model->id;?><br/>
    <?=$model->getAttributeLabel('email');?>:<?=$model->email;?><br/>
    <?php echo $model->getAttributeLabel('rolesAttribute');?>:<?=$model->rolesText;?><br/>
    <?=$model->getAttributeLabel('status');?>:<?=$model->statusText;?><br/>
    <?=$model->getAttributeLabel('created_at');?>:<?=Yii::$app->formatter->asDatetime($model->created_at);?><br/>
</div>