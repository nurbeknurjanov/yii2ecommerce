<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator mii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
<?php
$dateUse=false;
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
    <?php
    }
}
?>

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search advancedSearch"  style="<?="<?=isset(\$_GET['searchForm']) ? '':'display: none;';?>\"";?> >

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }
}
?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>

<p><?="<?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?>";?></p>