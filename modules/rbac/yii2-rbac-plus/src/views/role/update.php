<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model johnitvn\rbacplus\models\AuthItem */

if(!Yii::$app->request->isAjax){
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Roles Manager'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name'=>$model->name,]];
    $this->params['breadcrumbs'][] = $this->title;
    echo \yii\bootstrap\Html::tag('h1', $this->title);
}

?>
<div class="auth-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
