<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Users');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n{sorter}\n{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_index', ['model' => $model, 'key'=>$key, 'index'=>$index]);
            },
    ]); ?>

</div>
