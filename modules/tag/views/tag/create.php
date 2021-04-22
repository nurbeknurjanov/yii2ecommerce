<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model tag\models\Tag */

$this->title = Yii::t('common', 'Create Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Tags'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
