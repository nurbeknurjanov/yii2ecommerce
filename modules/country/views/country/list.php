<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel country\models\search\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Country');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Country-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createCountry'))
            echo Html::a(Yii::t('common', 'Create Country'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
        },
    ]) ?>

</div>
