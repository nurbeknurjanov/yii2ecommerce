<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel article\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('article', 'Articles');

if($searchModel->type)
    $this->title = $searchModel->typeText;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Alert::widget() ?>
    </p>

   <div class="row">
       <?= ListView::widget([
           'summary'=>false,
           'dataProvider' => $dataProvider,
           'itemOptions' => ['class' => 'item'],
           'itemView' => function ($model, $key, $index, $widget) {
               return $this->render('_list/_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
           },
       ]) ?>
   </div>

</div>