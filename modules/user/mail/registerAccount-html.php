<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $order order\models\Order */
/* @var $token user\models\Token */

use yii\helpers\Url;
use yii\helpers\Html;


$url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/token/run', 'token' => $token->token]);
echo Yii::t('order', 'If you want to manage your orders, you need to approve your email.');
?>

<?=Html::a(Yii::t('user', 'Approve email'), $url)?>