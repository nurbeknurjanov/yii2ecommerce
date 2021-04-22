<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model article\models\Article */

$this->title = Yii::t('common', 'Create Article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Articles'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create card">

  <div class="card-body">
      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>
  </div>


</div>
