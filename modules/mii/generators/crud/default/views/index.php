<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator mii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
<?php
$dateUse = false;
foreach ($generator->getTableSchema()->columns as $column)
{
    if($column->comment)
    {
        ?>
use <?=$column->comment?>;
<?php
    }
    if($column->dbType=='datetime' || $column->dbType=='date')
    {
        if(!$dateUse)
        {
        ?>
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
<?php
            $dateUse=true;
        }
        ?>

        /*
        $<?=$column->name;?> = DatePicker::widget([
            'model' => $searchModel,
            'attribute' => '<?=$column->name;?>',
            'dateFormat' => 'yyyy-MM-dd',
            'options'=>array('class'=>'col-lg-6',),
            ]);
        */


        $<?=$column->name;?>From = DateTimePicker::widget([
            'name' => '<?=$column->name;?>From',
            'value'=>isset($_GET['<?=$column->name;?>From']) ? $_GET['<?=$column->name;?>From']:null,
            //'model' => $searchModel,
            //'attribute' => '<?=$column->name;?>',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        $<?=$column->name;?>To = DateTimePicker::widget([
            'name' => '<?=$column->name;?>To',
            'value'=>isset($_GET['<?=$column->name;?>To']) ? $_GET['<?=$column->name;?>To']:null,
            //'model' => $searchModel,
            //'attribute' => '<?=$column->name;?>',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
            ]
        ]);
<?php

    }
}
?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>
    <?= "<?= Alert::widget() ?>\n" ?>


    <div class="card-header">
        <?= "<?php\n\t\t" ?>if(Yii::$app->user->can('create<?=StringHelper::basename($generator->modelClass);?>'))
            <?= "echo " ?>Html::a(<?= $generator->generateString('Create ' . strtolower(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, ['create'], ['class' => 'btn btn-success']);
        ?>
    </div>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            //['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
            if($column->dbType==='tinyint(1)')
            {
            ?>
            [
                'attribute'=>'<?=$column->name;?>',
                //'format'=>'boolean',
                'value'=>function($data){
                    return $data-><?=$column->name;?>Text;
                },
                'filter'=>$searchModel-><?=$column->name;?>Options,
            ],
<?php
            }
        elseif($column->dbType==='smallint(6)')
        {
            ?>
            [
                'attribute'=>'<?=$column->name;?>',
                'value'=>function($data){
                    return $data-><?=$column->name;?>Text;
                },
                'filter'=>$searchModel-><?=$column->name;?>Options,
            ],
<?php
        }
        elseif($column->comment)
        {
            $comment = explode("\\",$column->comment);
            $littleComment = end($comment);
            ?>
            [
                'attribute'=>'<?=$column->name;?>',
                'format'=>'raw',
                'value'=>function($data){
                    return $data-><?=lcfirst($littleComment);?> ? $data-><?=lcfirst($littleComment);?>->title:null;
                },
                'filter'=>ArrayHelper::map(\<?=$column->comment;?>::find()->all(), 'id', 'title'),
            ],
<?php
        }
        elseif($column->dbType==='datetime' || $column->dbType==='date')
        {
            ?>
            [
                'attribute'=>'<?=$column->name;?>',
                'format'=>'<?=$column->dbType;?>',
                'filter'=>$<?=$column->name;?>From.' '.$<?=$column->name;?>To,
            ],
<?php
        }
            else
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('view<?=StringHelper::basename($generator->modelClass);?>', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('update<?=StringHelper::basename($generator->modelClass);?>', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('delete<?=StringHelper::basename($generator->modelClass);?>', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

</div>
