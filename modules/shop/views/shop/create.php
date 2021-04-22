<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model shop\models\Shop */

$this->title = Yii::t('app', 'Create shop');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shops'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
