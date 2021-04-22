<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <?= "<?php\n\t\t" ?>if(Yii::$app->user->can('update<?=StringHelper::basename($generator->modelClass);?>', ['model' => $model]))
            <?= "echo " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']);
        ?>
        <?= "<?php\n" ?>
        if(Yii::$app->user->can('delete<?=StringHelper::basename($generator->modelClass);?>', ['model' => $model]))
            <?= "echo " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                    'method' => 'post',
                ],
            ]);
        ?>
    </div>

    <div class="card-body">
        <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'attributes' => [
    <?php
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            echo "            '" . $name . "',\n";
        }
    } else {
        foreach ($generator->getTableSchema()->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if($column->dbType==='tinyint(1)')
            {
                ?>
                [
                    'attribute'=>'<?=$column->name;?>',
                    //'format'=>'boolean',
                    'value'=>$model-><?=$column->name;?>Text,
                ],
    <?php
            }
            elseif($column->dbType==='smallint(6)')
            {
                ?>
                [
                    'attribute'=>'<?=$column->name;?>',
                    'value'=>$model-><?=$column->name;?>Text,
                ],
    <?php
            }
            elseif($column->dbType==='datetime' || $column->dbType==='date')
            {
                ?>
                [
                    'attribute'=>'<?=$column->name;?>',
                    'format'=>'<?=$column->dbType;?>',
                ],
    <?php
            }
            elseif($column->comment)
            {
                $comment = explode('\\',$column->comment);
                $comment = end($comment);
                ?>
                [
                    'attribute'=>'<?=$column->name;?>',
                    'format'=>'raw',
                    'value'=>$model-><?=lcfirst($comment);?> ? $model-><?=lcfirst($comment);?>->title:null,
                ],
    <?php
            }
            else
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
    ?>
            ],
        ]) ?>
    </div>
</div>
