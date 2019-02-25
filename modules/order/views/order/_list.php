<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
?>
<div class="col-lg-12 well">
    <b><?=Html::a($model->title, ['/order/order/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('user_id');?>: <?=$model->user ? $model->user->fullName:$model->name;?></b><br/>
    <b><?=$model->getAttributeLabel('created_at');?>: <?=Yii::$app->formatter->asDatetime($model->created_at);?></b><br/>
</div>