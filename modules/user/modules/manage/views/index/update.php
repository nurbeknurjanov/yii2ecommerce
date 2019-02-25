<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('common', 'Update {modelClass}: ', ['modelClass' => Yii::t('common', 'user')]) . ' ' . $model->fullName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="user-update">


    <div class="box">
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
