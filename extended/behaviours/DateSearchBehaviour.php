<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 3/2/18
 * Time: 11:35 AM
 */

namespace extended\behaviours;


use kartik\datetime\DateTimePicker;
use yii\base\Behavior;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\ActiveQuery;

class DateSearchBehaviour extends Behavior
{
    public $dateFrom;
    public $dateTo;
    public $dateAttribute;

    public function init()
    {
        parent::init();
        if(!$this->dateAttribute)
            throw new Exception("dateAttribute must be set.");
        $this->dateFrom = $this->dateAttribute.'From';
        $this->dateTo = $this->dateAttribute.'To';
    }

    public function searchFilterDate(ActiveDataProvider $dataProvider)
    {
        /* @var ActiveQuery $query */
        $query = $dataProvider->query;
        $query->defaultFrom();
        $from = key($query->from);

        if(isset($_GET[$this->dateFrom]))
            $query->andWhere("$from.$this->dateAttribute>=STR_TO_DATE('{$_GET[$this->dateFrom]}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET[$this->dateTo]))
            $query->andWhere("$from.$this->dateAttribute<=STR_TO_DATE('{$_GET[$this->dateTo]}', '%Y-%m-%d %H:%i:%s')");

        /*
         *   $dateTimeValidator = new DateValidator();
            $dateTimeValidator->format = 'yyyy-MM-dd HH:mm';
        if ($dateTimeValidator->validate($_GET['from'], $error)){
                //$query->andWhere("STR_TO_DATE(u.created_at, '%Y-%m-%d %H:%i')>='{$_GET['from']}'");
                $query->andWhere("u.created_at>='".strtotime($_GET['from'])."'");
            }
        $query->andWhere("u.created_at<='".(strtotime($_GET['to'])+24*3600-1)."'");
        */
    }

    public function getWidgetFilter($horizontal=false)
    {
        $dateFrom = DateTimePicker::widget([
            'name' => $this->dateFrom,
            'value'=>Yii::$app->request->get($this->dateFrom),
            //'model' => $searchModel,
            //'attribute' => 'created_at',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        $dateTo = DateTimePicker::widget([
            'name' => $this->dateTo,
            'value'=>Yii::$app->request->get($this->dateTo),
            //'model' => $searchModel,
            //'attribute' => 'created_at',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        if($horizontal){
            ob_start();
            ?>
            <div class='row'>
                <div class='col-lg-12' ><?=$dateFrom?></div>
                <div class='col-lg-12' ><?=$dateTo?></div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
        return $dateFrom.' '.$dateTo;

        /*
         *
         *  $updated_at = DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'updated_at',
            'dateFormat' => 'yyyy-MM-dd',
            'options'=>array('class'=>'col-lg-6',),
            ]);


                $options = [
                'options' => ['placeholder' => 'Select time', 'style'=>'width:120px;',],
                'size' => 'sm',
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-MM-dd H:i',
                    'todayHighlight' => true,
                ]
            ];
          $form->field($model, 'created_at', ['parts'=>[
            '{input}'=>\kartik\field\FieldRange::widget([
                //'form' => $form,
                //'model' => $model,
                'template'=> '{widget}{error}',
                'name1' => 'from',
                'value1' => isset($_GET['from']) ? $_GET['from']:'',
                'name2' => 'to',
                'value2' => isset($_GET['to']) ? $_GET['to']:null,
                'type' => \kartik\field\FieldRange::INPUT_WIDGET,
                'widgetClass' => \kartik\datetime\DateTimePicker::classname(),
                'widgetOptions1'=> \yii\helpers\ArrayHelper::merge($options, ['options'=>['placeholder'=>'From date'],]),
                'widgetOptions2'=> \yii\helpers\ArrayHelper::merge($options, ['options'=>['placeholder'=>'To date'],]),
                'widgetContainer'=>[
                    'class'=>'form-control',
                    'style'=>'box-shadow:none; border:inherit; padding:0; height:auto;',
                ],
            ])
        ],]) */
    }
}