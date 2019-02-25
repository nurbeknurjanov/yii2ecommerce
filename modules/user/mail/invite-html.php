<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $token user\models\Token */

$url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/token/run', 'token' => $token->token]);
?>
<div class="password-reset">
    <p>Hello,</p>

    <p>
        <?= Html::encode($user->fullName) ?> invited you to register. <br>

        Follow the link below to register:
    </p>

    <p>
        <?php  echo Html::a($url, $url) ?>
    </p>
</div>
