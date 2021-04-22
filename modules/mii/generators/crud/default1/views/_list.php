<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator mii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

?><?= "<?php\n" ?>
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?= "<?=" ?>Html::a($model->title, ['<?=strtolower(StringHelper::basename($generator->modelClass));?>/view', 'id'=>$model->id,]);?></b><br/>
<?php
    foreach ($generator->getTableSchema()->columns as $column)
    {
?>
    <b><?= "<?=" ?>$model->getAttributeLabel('<?=$column->name;?>');?>: <?= "<?=" ?>$model-><?=$column->name;?>;?></b><br/>
<?php
    }
?>
</div>