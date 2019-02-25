<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php
Modal::begin([
    'id'=>'videoModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('file', 'Video').'</h4>',
    'clientOptions' => ['show' => false],
]);
?>

<?php
Modal::end();
?>

