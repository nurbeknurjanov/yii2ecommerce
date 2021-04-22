<?php
use yii\helpers\Html;
/* @var $model \user\models\User */
?>
<div class="well">
    <?=$model->getAttributeLabel('name');?>:<?=Html::a($model->name, ['/user/user/view', 'id'=>$model->id,]);?><br/>
    <?php echo $model->getAttributeLabel('rolesAttribute');?>:<?=$model->rolesText;?><br/>
    <?=$model->getAttributeLabel('status');?>:<?=$model->statusText;?><br/>
    <?=$model->getAttributeLabel('created_at');?>:<?=Yii::$app->formatter->asDatetime($model->created_at);?><br/>
</div>