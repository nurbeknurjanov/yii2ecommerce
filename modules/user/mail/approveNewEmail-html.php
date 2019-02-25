<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $token user\models\Token */

$url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/token/run', 'token' => $token->token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->fullName) ?>,</p>

    <p>Follow the link below to approve your new email:</p>

    <p><?= Html::a($url, $url) ?></p>
</div>
