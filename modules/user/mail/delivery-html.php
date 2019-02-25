<?php
use yii\helpers\Html;
use user\models\Token;

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $email string */

$tokenString = Yii::$app->security->encryptByKey($email, 'email');
$url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/guest/unsubscribe', 'token' => $tokenString]);
?>
<div>

    <p><?=$content?></p>

    <br/>
    <br/>
    <br/>
    <p>
        <?php
        echo Yii::t('user', 'If you want to cancel the subscription, click to this {to_link}.', ['to_link'=>Html::a(Yii::t('user', 'to_link'), $url)])
        ?>
    </p>
</div>
