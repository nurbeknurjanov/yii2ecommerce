<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\City */

$this->title = Yii::t('country', 'Create City');
$this->params['breadcrumbs'][] = ['label' => Yii::t('country', 'Cities'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create card">


   <div class="card-body">
       <?= $this->render('_form', [
           'model' => $model,
       ]) ?>
   </div>

</div>
