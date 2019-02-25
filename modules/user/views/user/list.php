<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{sorter}\n{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
            },
    ]); ?>

</div>
