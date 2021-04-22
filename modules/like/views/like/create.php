<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model like\models\Like */

$this->title = Yii::t('common', 'Create like');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Likes'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="like-create card">


    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
