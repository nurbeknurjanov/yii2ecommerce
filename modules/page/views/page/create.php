<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model page\models\Page */

$this->title = Yii::t('common', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Pages'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
