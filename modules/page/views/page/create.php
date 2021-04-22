<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model page\models\Page */

$this->title = Yii::t('page', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Pages'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
