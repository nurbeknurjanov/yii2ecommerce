<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('common', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <div class="box">
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
