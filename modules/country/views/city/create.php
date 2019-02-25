<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\City */

$this->title = Yii::t('common', 'Create city');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Cities'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create box">


   <div class="box-body">
       <?= $this->render('_form', [
           'model' => $model,
       ]) ?>
   </div>

</div>
