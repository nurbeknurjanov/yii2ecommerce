<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="box">
    <div class="box-body">
        Run cron send email messages
        <code><?=Html::a("php yii cron/send-email-messages",
                ['/console/run', 'controller'=>'cron', 'action'=>'send-email-messages',]);?></code>
        <!--Run cron send  email messages to activate their accounts
<code><?/*=Html::a("php yii cron/send-activate-messages",
        ['/console/run', 'controller'=>'cron', 'action'=>'send-activate-messages',]);*/?></code>-->
        <hr>
        Run rbac initialize
        <code><?=Html::a("php yii rbac-init",
                ['/console/run', 'controller'=>'rbac-init', 'action'=>'index',]);?></code>
        <hr>
    </div>
</div>
