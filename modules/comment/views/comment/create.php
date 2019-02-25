<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model comment\models\Comment */

$this->title = Yii::t('common', 'Create {modelClass}', [
        'modelClass' => 'Comment',
    ]) ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Comments'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Create');

?>
<div class="comment-create box">


    <?php $this->beginBlock('form') ?>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <?php $this->endBlock() ?>
    {{form}}

</div>
