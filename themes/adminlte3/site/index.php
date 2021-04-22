<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var $this \yii\web\View */
use richardfan\widget\JSRegister;
use themes\adminlte3\assets\AdminLTEAsset;
use order\models\Order;
use yii\helpers\ArrayHelper;
use help\models\Help;
use yii\helpers\Json;
use order\models\OrderProduct;

$themeBundle = AdminLTEAsset::register($this);


?>


<div class="card card-primary">
    <div class="card-header with-border">
        <h3 class="card-title">Latest orders</h3>

        <div class="card-tools pull-right">
            <button type="button" class="btn btn-card-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-card-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="areaChart" style="height: 250px;"  height="250"></canvas>
        </div>
    </div>
    <!-- /.box-body -->
</div>


<div class="card card-danger">
    <div class="card-header with-border">
        <h3 class="card-title">Bestsellers</h3>

        <div class="card-tools pull-right">
            <button type="button" class="btn btn-card-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-card-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <canvas id="pieChart" style="height: 70px;" height="70"></canvas>
    </div>
    <!-- /.card-body -->
</div>


<?php
$orders = Order::find()->defaultOrder()->all();
$dateOfOrders = ArrayHelper::map($orders, 'created_at', function(Order $order){
    return Yii::$app->formatter->asDatetime($order->created_at, "php:d M H:i");
});
$amountOfOrders = ArrayHelper::map($orders, 'created_at', 'amount');
function js_str($s)
{
    return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}
function js_array($array)
{
    $temp = array_map('js_str', $array);
    return '[' . implode(',', $temp) . ']';
}
$dateOfOrders = js_array($dateOfOrders);
$amountOfOrders = js_array($amountOfOrders);

Yii::$app->db->createCommand("SET sql_mode='';")->execute();
$orderProducts = OrderProduct::find()->select(['product_id', 'count'=>'SUM(count)'])
    ->groupBy('product_id')->all();
$colors=[
    '#f56954',
    '#00a65a',
    '#f39c12',
    '#00c0ef',
    '#3c8dbc',
    '#d2d6de',
];
$n=0;
$orderProducts = ArrayHelper::map($orderProducts, 'product_id', function(OrderProduct $orderProduct) use (&$n, $colors){
    if(!isset($colors[$n]))
        $n=0;
    $return = [
        'value'=>$orderProduct->count,
        'label'=>$orderProduct->product->title,
        'color'=>$colors[$n],
        'highlight'=>$colors[$n],
    ];
    $n++;
    return $return;
});

$orderProducts = json_encode($orderProducts);
JSRegister::begin();
?>
<script>
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    var areaChart       = new Chart(areaChartCanvas);
    var areaChartData = {
        labels  : <?=$dateOfOrders?>,
        datasets: [
            {
                label               : 'Orders',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : <?=$amountOfOrders?>
            }
        ]
    };

    var areaChartOptions = {


        //Boolean - Whether to show a dot for each point
        pointDot                : false,
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio     : true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive              : true,
        scaleLabel: "<%=value%>$",
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>$"
    };
    areaChart.Line(areaChartData, areaChartOptions);


    //- PIE CHART -
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
    var PieData        = <?=$orderProducts?>;
    var pieOptions     = {
        responsive           : true,
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> pc"
    };
    pieChart.Doughnut(PieData, pieOptions);
</script>
<?php
JSRegister::end();
?>