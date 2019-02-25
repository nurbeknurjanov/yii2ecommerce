<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $token user\models\Token */

$url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/token/run', 'token' => $token->token]);
?>
<div class="password-reset">
    <p><?=Yii::t('user', 'Hello')?> <?= Html::encode($user->fullName) ?>,</p>

    <p><?=Yii::t('user', 'Follow the link below to complete your account')?>:</p>

    <p>
        <?php  echo Html::a(Yii::t('common', 'Complete'), $url) ?>
    </p>
</div>
