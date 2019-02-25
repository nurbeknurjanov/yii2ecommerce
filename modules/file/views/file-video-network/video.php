<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


use yii\helpers\Html;


?>

<?php
$video = $model;
if($video){
    ?>
    <?=$video->video;?>
    <?php
}
?>