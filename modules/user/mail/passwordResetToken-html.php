<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $token user\models\Token */


$resetLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/guest/reset-password', 'token' => $token->token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->fullName) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
