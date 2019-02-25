<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model category\models\Category */

$this->title = Yii::t('common', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Categories'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create box">


    <?php $this->beginBlock('form') ?>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <?php $this->endBlock() ?>
    {{form}}

</div>
